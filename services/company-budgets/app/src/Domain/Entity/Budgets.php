<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\OwnerId;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\BudgetLimit;
use App\Domain\ValueObject\BudgetPercentage;

class Budgets {
  private BudgetId $budgetId;
  private BudgetName $budgetName;
  private OwnerId $ownerId;
  private BudgetLimit $budgetLimit;
  private BudgetPercentage $budgetPercentage;

  public function __construct(BudgetId $budgetId,BudgetName $budgetName,OwnerId $ownerId,
                                BudgetLimit $budgetLimit, BudgetPercentage $budgetPercentage) {
    $this->budgetName = $budgetName;
    $this->ownerId = $ownerId;
    $this->budgetLimit = $budgetLimit;
    $this->budgetId = $budgetId;
    $this->budgetPercentage = $budgetPercentage;
  } 

  public function getId(): BudgetId {
    return $this->budgetId;
  }

  public function getName(): BudgetName {
    return $this->budgetName;
  }
  public function getOwnerId(): OwnerId {
    return $this->ownerId;
  }

  public function getBudgetLimit(): BudgetLimit {
    return $this->budgetLimit;
  }
  
  public function getBudgetPercentage(): BudgetPercentage {
    return $this->budgetPercentage;
  }

}