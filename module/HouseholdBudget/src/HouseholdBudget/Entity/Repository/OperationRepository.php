<?php

namespace HouseholdBudget\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class OperationRepository extends EntityRepository {

    public function getMonthlySummaryByType($user_id, $operationType, $year) {
        if($operationType == 'income')
            $operationType = 1;
        else
            $operationType = 3;
        
        $sql = 'SELECT SUM(o.amount) AS total, YEAR(o.date) AS year, MONTH(o.date) AS month '
             . 'FROM operation o '
             . 'WHERE o.user_id = ? AND o.operation_type_id = ? AND YEAR(o.date) = ?'
             . 'GROUP BY YEAR(o.date), MONTH(o.date)';
        
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('total', 'total');
        $rsm->addScalarResult('year', 'year');
        $rsm->addScalarResult('month', 'month');
               
        $query = $this->_em->createNativeQuery($sql, $rsm);
        
        $query->setParameter(1, $user_id);
        $query->setParameter(2, $operationType);
        $query->setParameter(3, $year);

        return $query->getResult();
    }

}
