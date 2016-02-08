<?php

namespace HouseholdBudget\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class StatsController extends AbstractActionController
{

    public function indexAction()
    {
        $em = $this->EntityPlugin()->getEntityManager();
        
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $user = $auth->getIdentity();
        
        $year = $this->params()->fromRoute('year');
        
        $date = new \DateTime();
        if(!empty($year)) {
            $date->setDate($year, 1, 1);
        }
        
        $operationsSummaryIncome = $em->getRepository('HouseholdBudget\Entity\Operation')->getMonthlySummaryByType($user->getId(), 'income', $date->format('Y'));
        $operationsSummaryExpense = $em->getRepository('HouseholdBudget\Entity\Operation')->getMonthlySummaryByType($user->getId(), 'expense', $date->format('Y'));
        
        $highestIncome = 0;
        foreach ($operationsSummaryIncome as $income) {
            if($highestIncome < $income['total']) {
                $highestIncome = $income['total'];
            }
        }
        
        $highestExpense = 0;
        foreach ($operationsSummaryExpense as $expense) {
            if($highestExpense < $expense['total']) {
                $highestExpense = $expense['total'];
            }
        }
        echo '<pre>';
//        echo var_dump($operationsSummaryIncome);
//        echo var_dump($operationsSummaryExpense);
        echo '</pre>';

        return new ViewModel(array(
            'operationsSummaryIncome' => $operationsSummaryIncome,
            'operationsSummaryExpense' => $operationsSummaryExpense,
            'highestValue' => (($highestIncome > $highestExpense) ? $highestIncome : $highestExpense),
            'date' => $date
        ));
    }


}

