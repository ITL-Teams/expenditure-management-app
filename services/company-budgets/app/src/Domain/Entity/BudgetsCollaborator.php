<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\BudgetName;

class BudgetsCollaborator {
  private BudgetId $budgetId;
  private BudgetName $budgetName;

  public function __construct(BudgetId $budgetId,BudgetName $budgetName) {
    $this->budgetId = $budgetId;
    $this->budgetName = $budgetName;
  }
    
  public function getBudegtId(): BudgetId {
    return $this->budgetId;
  }
  
  public function getBudgetName(): BudgetName {
    return $this->budgetName;
  }

}