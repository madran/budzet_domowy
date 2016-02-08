<?php

namespace HouseholdBudget\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

class OperationForm extends Form {

    public function __construct(EntityManager $em) {
        parent::__construct('expense');

        $this->add(array(
            'name' => 'amount',
            'options' => array(
                'label' => 'Amount: '
            ),
            'attributes' => array(
                'required' => true
            )
        ));
        $this->add(array(
            'name' => 'wallet',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Wallet: ',
            ),
            'attributes' => array(
                'required' => true
            )
        ));
        $this->add(array(
            'name' => 'wallet2',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Wallet: ',
            ),
            'attributes' => array(
                'required' => true
            )
        ));
        $this->add(array(
            'type' => 'textarea',
            'name' => 'description',
            'options' => array(
                'label' => 'Description: '
            ),
        ));
        $this->add(array(
            'name' => 'user_id',
            'attributes' => array(
                'type' => 'hidden',
            )
        ));
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Save',
                'id' => 'submitbutton',
            ),
        ));
    }

}
