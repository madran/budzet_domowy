<?php

namespace HouseholdBudget\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use HouseholdBudget\Entity\User;
use HouseholdBudget\Form\LoginForm;
use HouseholdBudget\Form\LoginInputFilter;

class IndexController extends AbstractActionController {
    
    public function indexAction() {
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');


        if (!$auth->hasIdentity()) {

            return $this->redirect()->toRoute('home/login');

        }
        return new ViewModel();
    }

    public function loginAction() {
        $form = new LoginForm();
        $form->get('submit')->setValue('Login');
        $messages = null;

        $request = $this->getRequest();
        if ($request->isPost()) {

            $form->setInputFilter(new LoginInputFilter($this->getServiceLocator()));
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();
                $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
                $adapter = $authService->getAdapter();
                $adapter->setIdentityValue($data['username']);
                $adapter->setCredentialValue($data['password']);
                $authResult = $authService->authenticate();

                if ($authResult->isValid()) {
                    $identity = $authResult->getIdentity();
                    $authService->getStorage()->write($identity);
                    $time = 1209600;
                    
                    if ($data['rememberme']) {
                        $sessionManager = new \Zend\Session\SessionManager();
                        $sessionManager->rememberMe($time);
                    }

                }
                foreach ($authResult->getMessages() as $message) {
                    $messages .= "$message\n";
                }
                return $this->redirect()->toRoute('home');
            }
        }
        return new ViewModel(array(
            'error' => 'Your authentication credentials are not valid',
            'form' => $form,
            'messages' => $this->flashMessenger()->getMessages(),
        ));
    }

    public function logoutAction() {
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');


        if ($auth->hasIdentity()) {

            $identity = $auth->getIdentity();

        }
        $auth->clearIdentity();

        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->forgetMe();

        return $this->redirect()->toRoute('home/login');
    }


    public function authTestAction() {
        if ($user = $this->identity()) {

        } else {

        }
    }
}
