<?php

namespace HouseholdBudget\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use HouseholdBudget\Form\WalletForm;
use HouseholdBudget\Form\WalletInputFilter;
use HouseholdBudget\Entity\Wallet;
use HouseholdBudget\Entity\Operation;

class WalletsController extends AbstractActionController {

    public function indexAction() {

        $em = $this->EntityPlugin()->getEntityManager();

        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $user = $auth->getIdentity();

        $wallets = $em->getRepository('HouseholdBudget\Entity\Wallet')->getAllWalletsSummary($user->getId());

        return new ViewModel(array('wallets' => $wallets));
    }

    public function addAction() {
        $form = new WalletForm();

        if ($this->getRequest()->isPost()) {
            $form->setInputFilter(new WalletInputFilter());
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                $wallet = new Wallet();
                $wallet->setName($this->getRequest()->getPost('name'));
                $wallet->setDescription($this->getRequest()->getPost('description'));

                $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
                $user = $auth->getIdentity();

                $wallet->setUser($user);

                $em = $this->EntityPlugin()->getEntityManager();
                $em->persist($wallet);
                $em->flush();

                return $this->redirect()->toRoute('home/wallets');
            }
        }

        return new ViewModel(array('form' => $form));
    }

    public function editAction() {
        $em = $this->EntityPlugin()->getEntityManager();

        $user_id = $this->params()->fromRoute('id');
        if (!$user_id && !$this->getRequest()->isPost()) {
            return $this->redirect()->toRoute('home/wallets');
        }

        $wallet = $em->find('HouseholdBudget\Entity\Wallet', $user_id);

        $form = new WalletForm();
        $form->setHydrator(new DoctrineEntity($em, 'HouseholdBudget\Entity\Wallet'));
        $form->bind($wallet);

        if ($this->getRequest()->isPost()) {
            $form->setInputFilter(new WalletInputFilter());
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $em->persist($wallet);
                $em->flush();

                return $this->redirect()->toRoute('home/wallets');
            }
        }
        
        return new ViewModel(
                array('form' => $form, 'id' => $user_id)
        );
    }

    public function deleteAction() {
        $wallet_id = $this->params()->fromRoute('id');
        if (!$wallet_id) {
            return $this->redirect()->toRoute('home/wallets');
        }

        $em = $this->EntityPlugin()->getEntityManager();
        
        $wallet_sum = $em->getRepository('HouseholdBudget\Entity\Wallet')->getOneWalletSummary($wallet_id);

        if ($wallet_sum->getTotal() == 0) {
            $wallet = $em->find('HouseholdBudget\Entity\Wallet', $wallet_id);
            $wallet->setDeleted(1);
            $em->persist($wallet);
            $em->flush();
        } else {
            $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
            $user = $auth->getIdentity();
            
            $wallet = $em->find('HouseholdBudget\Entity\Wallet', $wallet_id);
            $operationType = $em->find('HouseholdBudget\Entity\OperationType', 3);

            $operation = new Operation();
            $operation->setAmount(-$wallet_sum->getTotal());
            $operation->setDescription('Removal of the wallet.');
            $operation->setOperationType($operationType);
            $operation->setUser($user);
            $operation->setWallet($wallet);

            $em->persist($operation);
            $em->flush();
            
            $wallet->setDeleted(1);
            
            $em->persist($wallet);
            $em->flush();
        }
        $this->redirect()->toRoute('home/wallets');
    }

    public function showAction() {
        $em = $this->EntityPlugin()->getEntityManager();

        $id = $this->params()->fromRoute('id');



        $wallet = $em->find('HouseholdBudget\Entity\Wallet', $id);

        //$total

        return new ViewModel(array('operation' => $wallet));
    }

}
