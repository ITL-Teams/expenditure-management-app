<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\BudgetPercentage;
use App\Domain\ValueObject\BudgetLimit;

class BudgetQuantities {
  private BudgetPercentage $budgetPercentage;
  private BudgetLimit $budgetLimit;

  public function __construct(BudgetPercentage $budgetPercentage,BudgetLimit $budgetLimit) {
    $this->budgetPercentage = $budgetPercentage;
    $this->budgetLimit = $budgetLimit;
  }
    
  public function getPercentage(): BudgetPercentage {
    return $this->budgetPercentage;
  }
  
  public function getBudgetLimit(): BudgetLimit {
    return $this->budgetLimit;
  }

}