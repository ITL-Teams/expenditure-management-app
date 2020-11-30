<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\BudgetLimit;

class Budget {
  private BudgetId $budgetId;
  private BudgetName $budgetName;
  private BudgetLimit $budgetLimit;

  public function __construct(BudgetName $budgetName,BudgetLimit $budgetLimit, BudgetId $budgetId) {
    $this->budgetName = $budgetName;
    $this->budgetLimit = $budgetLimit;
    $this->budgetId = $budgetId;
  }
    
  public function getId(): BudgetId {
    return $this->budgetId;
  }

  public function getName(): BudgetName {
    return $this->budgetName;
  }
  
  public function getBudgetLimit(): BudgetLimit {
    return $this->budgetLimit;
  }

}