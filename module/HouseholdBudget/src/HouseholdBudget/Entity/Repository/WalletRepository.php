<?php
namespace HouseholdBudget\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class WalletRepository extends EntityRepository
{
    public function getAllWalletsSummary($user_id)
    {
        $dql = 'SELECT NEW HouseholdBudget\Entity\DTO\WalletSummaryDTO(w.id, w.description, w.name, SUM(o.amount)) '.
               'FROM HouseholdBudget\Entity\Wallet w '.
               'LEFT JOIN HouseholdBudget\Entity\Operation o WITH w.id = o.wallet '.
               'WHERE w.deleted = 0 AND w.user = ?1'.
               'GROUP BY w.name, o.user '.
               'ORDER BY w.id ASC';

        $query = $this->_em->createQuery($dql);
        $query->setParameter(1, $user_id);
        
        return $query->getResult();
    }
    
    public function getOneWalletSummary($wallet_id)
    {
        $dql = 'SELECT NEW HouseholdBudget\Entity\DTO\WalletSummaryDTO(w.id, w.description, w.name, SUM(o.amount)) '
             . 'FROM HouseholdBudget\Entity\Operation o '
             . 'JOIN o.wallet w '
             . 'WHERE w.deleted = 0 AND w.id = ?1 '
             . 'GROUP BY w.name '
             . 'ORDER BY w.id ASC';
                
        $query = $this->_em->createQuery($dql);
        $query->setParameter(1, $wallet_id);
        
        return $query->getSingleResult();
    }
    
    public function getWalletsByUser($user_id) {
        $dql = 'SELECT w.id, w.name '
             . 'FROM HouseholdBudget\Entity\Wallet w '
             . 'WHERE w.deleted = 0 AND w.user = ?1';

        $query = $this->_em->createQuery($dql);
        $query->setParameter(1, $user_id);
        
        return $query->getResult();
    }
}