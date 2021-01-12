<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\OwnerId;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\AMount;
use App\Domain\ValueObject\Type;

class Budgets {
  private BudgetId $budgetId;
  private BudgetName $budgetName; 
  private OwnerId $ownerId;
  private AMount $amount;
  private Type $type;

  public function __construct(BudgetId $budgetId,BudgetName $budgetName,OwnerId $ownerId,
                                AMount $amount, Type $type) {
    $this->budgetName = $budgetName;
    $this->ownerId = $ownerId;
    $this->amount = $amount;
    $this->budgetId = $budgetId;
    $this->type = $type;
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

  public function getAMount(): AMount {
    return $this->amount;
  }
  
  public function getType(): Type {
    return $this->type;
  }

}