<?php

namespace HouseholdBudget\Form;

use Zend\Form\Form;

class WalletForm extends Form {

    public function __construct() {
        parent::__construct('wallet');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            )
        ));
        $this->add(array(
            'name' => 'name',
            'options' => array(
                'label' => 'Name: '
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
            )
        ));
        $this->add(array(
            'name' => 'user_id',
            'attributes' => array(
                'type' => 'hidden',
            )
        ));
        $this->add(array(
            'name' => 'deleted',
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
