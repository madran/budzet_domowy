<?php

namespace HouseholdBudget\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use HouseholdBudget\Form\OperationInputFilter;
use HouseholdBudget\Form\OperationForm;
use HouseholdBudget\Entity\Operation;

class OperationsController extends AbstractActionController {

    public function indexAction() {
        $em = $this->EntityPlugin()->getEntityManager();

        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $user = $auth->getIdentity();

        $operations = $em->getRepository('HouseholdBudget\Entity\Operation')->findBy(array('user' => $user->getId()), array('date' => 'DESC'));

        return new ViewModel(array(
            'operations' => $operations,
            'messages' => $this->flashMessenger()->getMessages()
        ));
    }

    public function addAction() {
        $em = $this->EntityPlugin()->getEntityManager();

        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $user = $auth->getIdentity();

        $wallets = $em->getRepository('HouseholdBudget\Entity\Wallet')->getWalletsByUser($user->getId());

        if (!$wallets) {
            $this->flashMessenger()->addMessage('First, add wallet.');
            return $this->redirect()->toRoute('home/operations');
        }

        $form = new OperationForm($em);

        $options = array();
        foreach ($wallets as $wallet) {
            $options[$wallet['id']] = $wallet['name'];
        }

        $form->get('wallet')->setValueOptions($options);

        $operationType = $this->params()->fromRoute('type');

        if ($operationType == 'transfer') {
            $form->get('wallet2')->setValueOptions($options);
            if ($this->getRequest()->isPost()) {
                $form->setInputFilter(new OperationInputFilter());
                $form->setData($this->getRequest()->getPost());

                if ($form->isValid()) {
                    $operation1 = new Operation();
                    $operation1->setAmount(-(int) $this->getRequest()->getPost('amount'));
                    $operation1->setDescription($this->getRequest()->getPost('description'));
                    $wallet = $em->find('HouseholdBudget\Entity\Wallet', $this->getRequest()->getPost('wallet'));
                    $operationType = $em->getRepository('HouseholdBudget\Entity\OperationType')->findOneBy(array('name' => $operationType));
                    $operation1->setUser($user);
                    $operation1->setWallet($wallet);
                    $operation1->setOperationType($operationType);


                    $operation2 = new Operation();
                    $operation2->setAmount($this->getRequest()->getPost('amount'));
                    $operation2->setDescription($this->getRequest()->getPost('description'));
                    $wallet = $em->find('HouseholdBudget\Entity\Wallet', $this->getRequest()->getPost('wallet2'));
                    $operation2->setUser($user);
                    $operation2->setWallet($wallet);
                    $operation2->setOperationType($operationType);

                    $em->persist($operation2);
                    $em->flush();


                    $em->persist($operation1);
                    $em->flush();

                    return $this->redirect()->toRoute('home/operations');
                }
            }
        } else {
            $form->remove('wallet2');
            if ($this->getRequest()->isPost()) {
                $form->setInputFilter(new OperationInputFilter());
                $form->setData($this->getRequest()->getPost());

                if ($form->isValid()) {
                    $operation = new Operation();
                    $amount = ($operationType == 'expense') ? -(int) $this->getRequest()->getPost('amount') : $this->getRequest()->getPost('amount');
                    $operation->setAmount($amount);
                    $operation->setDescription($this->getRequest()->getPost('description'));

                    $wallet = $em->find('HouseholdBudget\Entity\Wallet', $this->getRequest()->getPost('wallet'));

                    $operationType = $em->getRepository('HouseholdBudget\Entity\OperationType')->findOneBy(array('name' => $operationType));

                    $operation->setUser($user);
                    $operation->setWallet($wallet);
                    $operation->setOperationType($operationType);
                    $em->persist($operation);
                    $em->flush();

                    return $this->redirect()->toRoute('home/operations');
                }
            }
        }

        return new ViewModel(array('form' => $form, 'operationType' => $operationType));
    }

    public function editAction() {
        $em = $this->EntityPlugin()->getEntityManager();

        $id = $this->params()->fromRoute('id');

        if (!$id && !$this->getRequest()->isPost()) {
            return $this->redirect()->toRoute('home/operations');
        }

        $operation = $em->find('HouseholdBudget\Entity\Operation', $id);

        $form = new OperationForm($em);
        $form->setHydrator(new DoctrineEntity($em, 'HouseholdBudget\Entity\Operation'));
        $form->bind($operation);

        if ($this->getRequest()->isPost()) {
            $form->setInputFilter(new OperationInputFilter());
            $form->setData($this->getRequest()->getPost());

            $filter = $form->getInputFilter();
            $input_element = $filter->get('description');

            if ($input_element->isValid()) {
                $operation->setDescription($this->getRequest()->getPost('description'));
                $em->persist($operation);
                $em->flush();

                return $this->redirect()->toRoute('home/operations');
            }
        }
        return new ViewModel(
                array('form' => $form, 'id' => $id)
        );
    }

    public function deleteAction() {
        $operation_id = $this->params()->fromRoute('id');
        if (!$operation_id) {
            return $this->redirect()->toRoute('home/wallets');
        }

        $em = $this->EntityPlugin()->getEntityManager();

        $operation = $em->find('HouseholdBudget\Entity\Operation', $operation_id);

        $em->remove($operation);
        $em->flush();

        $this->redirect()->toRoute('home/operations');
    }

}
