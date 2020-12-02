<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\BudgetName;

class OwnerBudgets {
  private BudgetId $budgetId;
  private BudgetName $budgetName;
  

  public function __construct(BudgetId $budgetId,BudgetName $budgetName) {
    $this->budgetId = $budgetId;
    $this->budgetName = $budgetName;
  }

  public function getId(): BudgetId {
    return $this->budgetId;
  }

  public function getName(): BudgetName {
    return $this->budgetName;
  }
}