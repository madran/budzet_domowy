<?php

namespace HouseholdBudget\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Operation
 *
 * @ORM\Table(name="operation", indexes={@ORM\Index(name="fk_operation_wallet1", columns={"wallet_id"}), @ORM\Index(name="fk_operation_user1", columns={"user_id"}), @ORM\Index(name="fk_operation_operation_type1", columns={"operation_type_id"})})
 * @ORM\Entity(repositoryClass="HouseholdBudget\Entity\Repository\OperationRepository")
 */
class Operation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer", nullable=false)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \HouseholdBudget\Entity\Wallet
     *
     * @ORM\ManyToOne(targetEntity="HouseholdBudget\Entity\Wallet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="wallet_id", referencedColumnName="id")
     * })
     */
    private $wallet;

    /**
     * @var \HouseholdBudget\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="HouseholdBudget\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \HouseholdBudget\Entity\OperationType
     *
     * @ORM\ManyToOne(targetEntity="HouseholdBudget\Entity\OperationType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="operation_type_id", referencedColumnName="id")
     * })
     */
    private $operationType;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     * @return Operation
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Operation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Operation
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set wallet
     *
     * @param \HouseholdBudget\Entity\Wallet $wallet
     * @return Operation
     */
    public function setWallet(\HouseholdBudget\Entity\Wallet $wallet = null)
    {
        $this->wallet = $wallet;

        return $this;
    }

    /**
     * Get wallet
     *
     * @return \HouseholdBudget\Entity\Wallet 
     */
    public function getWallet()
    {
        return $this->wallet;
    }

    /**
     * Set user
     *
     * @param \HouseholdBudget\Entity\User $user
     * @return Operation
     */
    public function setUser(\HouseholdBudget\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \HouseholdBudget\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set operationType
     *
     * @param \HouseholdBudget\Entity\OperationType $operationType
     * @return Operation
     */
    public function setOperationType(\HouseholdBudget\Entity\OperationType $operationType = null)
    {
        $this->operationType = $operationType;

        return $this;
    }

    /**
     * Get operationType
     *
     * @return \HouseholdBudget\Entity\OperationType 
     */
    public function getOperationType()
    {
        return $this->operationType;
    }
}
