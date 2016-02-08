<?php

namespace HouseholdBudget\Form;

use Zend\Form\Form;

class UserDeleteForm extends Form {
  public function __construct($name = null) {
    parent::__construct('user_delete');

    $this->setAttribute('method', 'post');

    $this->add(array(
      'type' => 'Zend\Form\Element\Csrf',
      'name' => 'csrf',
    ));
    $this->add(array(
      'name' => 'id',
      'attributes' => array(
        'type' => 'hidden',
      )
    ));


    $this->add(array(
      'name' => 'submit',
      'attributes' => array(
        'type' => 'submit',
        'value' => 'Delete',
        'id' => 'submitbutton',
      ),
    ));
  }
}
