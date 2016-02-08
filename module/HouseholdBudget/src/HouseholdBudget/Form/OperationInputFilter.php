<?php

namespace HouseholdBudget\Form;

use Zend\InputFilter\InputFilter;

class OperationInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'amount',
            'required' => true,
            'filters' => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
            'validators' => array(
                array('name' => 'not_empty'),
                array('name' => 'regex',
                      'options' => array('pattern' => '/^(\d*[.])?\d+$/')),
            ),
        ));
        
        $this->add(array(
            'name' => 'description',
            'required' => false,
            'filters' => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
        ));
    }
}
