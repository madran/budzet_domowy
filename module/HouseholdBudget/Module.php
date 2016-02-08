<?php

namespace HouseholdBudget;

use Zend\ServiceManager\ServiceManager;
use Zend\EventManager\StaticEventManager;
use \HouseholdBudget\Acl\Acl;

class Module {

    public function init() {
        $events = StaticEventManager::getInstance();
        $events->attach('Zend\Mvc\Controller\ActionController', 'dispatch', array($this, 'mvcPreDispatch'), 100); //@todo - Go directly to User\Event\Authentication
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function mvcPreDispatch($event) {
        $di = $event->getTarget()->getLocator();
        $auth = $di->get('HouseholdBudget\Event\Authentication');

        return $auth->preDispatch($event);
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Zend\Authentication\AuthenticationService' => function($serviceManager) {

            return $serviceManager->get('doctrine.authenticationservice.orm_default');
        },
                'mail.transport' => function (ServiceManager $serviceManager) {
            $config = $serviceManager->get('Config');
            $transport = new Smtp();
            $transport->setOptions(new SmtpOptions($config['mail']['transport']['options']));
            return $transport;
        },
            )
        );
    }

    public function onBootstrap(\Zend\EventManager\EventInterface $e) {
        $application = $e->getApplication();
        $em = $application->getEventManager();
        $em->attach('route', array($this, 'onRoute'), -100);
    }

    public function onRoute(\Zend\EventManager\EventInterface $e) {
        $application = $e->getApplication();
        $routeMatch = $e->getRouteMatch();
        $sm = $application->getServiceManager();
        $auth = $sm->get('Zend\Authentication\AuthenticationService');
        $config = $sm->get('Config');
        $acl = new Acl($config);

        $role = Acl::DEFAULT_ROLE;


        if ($auth->hasIdentity()) {
            $user = $auth->getIdentity();
            $role = $user->getUserRole()->getRole();
        }


        $controller = $routeMatch->getParam('controller');
        $action = $routeMatch->getParam('action');

        if (!$acl->hasResource($controller)) {
            throw new \Exception('Resource ' . $controller . ' not defined');
        }

        if (!$acl->isAllowed($role, $controller, $action)) {
            $url = $e->getRouter()->assemble(array(), array('name' => 'home/login'));
            $response = $e->getResponse();

            $response->getHeaders()->addHeaderLine('Location', $url);

            $response->setStatusCode(302);
            $response->sendHeaders();
            exit;
        }
    }

}
