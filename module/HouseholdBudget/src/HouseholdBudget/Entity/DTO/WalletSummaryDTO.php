<?php

namespace HouseholdBudget\Entity\DTO;


class WalletSummaryDTO
{
    private $id;
    private $description;
    private $name;
    private $total;
    
    public function __construct($id, $description, $name, $total)
    {
        $this->setId($id);
        $this->setDescription($description);
        $this->setName($name);
        $this->setTotal($total);
    }
    
    public function getId() {
        return $this->id;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getName() {
        return $this->name;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setTotal($amount) {
        $this->total = $amount;
    }


}

