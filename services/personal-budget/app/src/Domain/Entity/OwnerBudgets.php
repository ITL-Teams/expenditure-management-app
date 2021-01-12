<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\BudgetId;



class OwnerBudgets
{
    
    private BudgetName $budgetName;
   
    private BudgetId $budgetId;
    

    public function __construct(
        BudgetId $budgetId,
        BudgetName $budgetName
       
     ) {
        $this->budgetId = $budgetId;
        $this->budgetName = $budgetName;
    }
    public function getName(): BudgetName
    {
        return $this->budgetName;
    }

    public function getId(): BudgetId
    {
        return $this->budgetId;
    }
}
