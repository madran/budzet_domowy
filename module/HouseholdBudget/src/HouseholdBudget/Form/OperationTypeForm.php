<?php

namespace HouseholdBudget\Form;

use Zend\Form\Form;

class OperationForm extends Form {

    public function __construct() {
        parent::__construct('operation');

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
