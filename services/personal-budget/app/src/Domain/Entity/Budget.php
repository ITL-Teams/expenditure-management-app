<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\AMount;
use App\Domain\ValueObject\Type;
use App\Domain\Entity\Income;


class Budget {
  
  private BudgetId $budgetId;
  private BudgetName $budgetName;
  private AMount $amount;
  private Type $type;


  public function __construct(
    BudgetName $budgetName,
    AMount $amount,
    Type $type, 
    BudgetId $budgetId) 
  {
    $this->budgetName = $budgetName;
    $this->amount = $amount;
    $this->type = $type;
    $this->budgetId = $budgetId;
  }
    
  public function getId(): BudgetId {
    return $this->budgetId;
  }

  public function getName(): BudgetName {
    return $this->budgetName;
  }
  
  public function getAMount(): AMount {
    return $this->amount;
  }

  public function getType(): Type {
    return $this->type;
  }

}