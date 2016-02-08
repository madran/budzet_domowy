<?php

namespace HouseholdBudget\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use HouseholdBudget\Entity\User;
use HouseholdBudget\Form\UserInputFilter;
use HouseholdBudget\Form\UserForm;
use HouseholdBudget\Form\UserDeleteForm;

class UsersController extends AbstractActionController {

    public function indexAction() {
        $em = $this->EntityPlugin()->getEntityManager();
        $qb = $em->createQueryBuilder();
        
        $qb->select('u.id, u.username')
           ->from('HouseholdBudget\Entity\User', 'u')
           ->where('u.id != 1');
        
        $query = $qb->getQuery();

        $users = $query->getResult();

        return new ViewModel(array(
          'users' => $users,
          'messages' => $this->flashMessenger()->getMessages()
        ));
    }

    public function addAction() {
        $em = $this->EntityPlugin()->getEntityManager();
        $user = new User;

        $form = new UserForm();
        $form->get('submit')->setValue('Register');
        $form->setHydrator(new DoctrineHydrator($em, 'HouseholdBudget\Entity\User'));

        $form->bind($user);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter(new UserInputFilter($em));
            $form->setData($request->getPost());
            if ($form->isValid()) {
                //$this->prepareData($user);
                $userRole = $em->find('HouseholdBudget\Entity\Role', 2);
                $user->setUserRole($userRole);
                $user->setPassword(md5($form->get('password')->getValue()));
                $em->persist($user);
                $em->flush();
                
                $this->flashMessenger()->addMessage('Account created.');
                return $this->redirect()->toRoute('home/login');
            }
        }
        return new ViewModel(array('form' => $form));
    }

    public function deleteAction() {
      
        $em = $this->EntityPlugin()->getEntityManager();
      
        $user_id = $this->params()->fromRoute('id');
        if (!$user_id) {
            return $this->redirect()->toRoute('home/users');
        }
        
        if($this->getRequest()->isPost()) {
        
            $operation = $em->find('HouseholdBudget\Entity\User', $user_id);
            $em->remove($operation);
            $em->flush();

            $this->flashMessenger()->addMessage('User was deleted.');
            return $this->redirect()->toRoute('home/users');
        } else {
            $user = $em->find('HouseholdBudget\Entity\User', $user_id);
            if(!$user)
              return $this->redirect()->toRoute('home/users');
            $form = new UserDeleteForm();
            return new ViewModel(array('form' => $form, 'id' => $user_id, 'user' => $user ));
        }


    }

}
