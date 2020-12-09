<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\OwnerId;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\BudgetLimit;

class CompanyBudget {
  private BudgetId $budgetId;
  private BudgetName $budgetName;
  private OwnerId $ownerId;
  private BudgetLimit $budgetLimit;

  public function __construct(BudgetName $budgetName,OwnerId $ownerId,BudgetLimit $budgetLimit, BudgetId $budgetId = null) {
    $this->budgetName = $budgetName;
    $this->ownerId = $ownerId;
    $this->budgetLimit = $budgetLimit;
    $this->budgetId = $budgetId != null ? $budgetId : new BudgetId($this->generateId());
  }

  private function generateId(): string {
    $random = (float)rand() / (float)getrandmax() * 100;
    settype($random, 'integer');
    $date = new \DateTime();
    return $date->getTimestamp() . $random;
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

}