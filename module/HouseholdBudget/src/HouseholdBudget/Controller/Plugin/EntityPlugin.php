<?php
namespace HouseholdBudget\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class EntityPlugin extends AbstractPlugin {
    /**
     * @var EntityManager
     */
    protected $entityManager = null;

    /**
     * Sets the EntityManager
     *
     * @param EntityManager $em
     * @access protected
     * @return PostController
     */
    public function setEntityManager($em)
    {
        $this->entityManager = $em;
        return $this;
    }

    /**
     * Returns the EntityManager
     *
     * Fetches the EntityManager from ServiceLocator if it has not been initiated
     * and then returns it
     *
     * @access protected
     * @return EntityManager
     */
    public function getEntityManager()
    {
        if (null === $this->entityManager) {
            $this->setEntityManager($this->getController()->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
        }
        return $this->entityManager;
    }
}