<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\OwnerId;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\BudgetLimit;
use App\Domain\Entity\ArrayCollaborators;
use App\Domain\Entity\ArrayCharges;

class BudgetsMaster {
  private BudgetId $budgetId;
  private OwnerId $ownreId;
  private BudgetName $budgetName;
  private BudgetLimit $budgetLimit;
  private String $budgetStatus;
  private Int $budgetAssigned;
  private ArrayCollaborators $arrayCollaborators;
  private ArrayCharges $arrayCharges;


  public function __construct(BudgetId $budgetId,OwnerId $ownerId,BudgetName $budgetName,BudgetLimit $budgetLimit,
                                 String $budgetStatus,Int $budgetAssigned,ArrayCollaborators $arrayCollaborators,
                                 ArrayCharges $arrayCharges) {
    $this->budgetId = $budgetId;
    $this->ownreId = $ownerId;
    $this->budgetName = $budgetName;
    $this->budgetLimit = $budgetLimit;
    $this->budgetStatus = $budgetStatus;
    $this->budgetAssigned = $budgetAssigned;
    $this->arrayCollaborators = $arrayCollaborators;
    $this->arrayCharges = $arrayCharges;
  }
    
  public function getId(): BudgetId {
    return $this->budgetId;
  }
  
  public function getOwnerId(): OwnerId {
    return $this->ownreId;
  }

  public function getName(): BudgetName {
    return $this->budgetName;
  }
  
  public function getBudgetLimit(): BudgetLimit {
    return $this->budgetLimit;
  }
  
  public function getBudgetStatus(): String {
    return $this->budgetStatus;
  }
  
  public function getBudgetAssigned(): Int {
    return $this->budgetAssigned;
  }
  
  public function getCollaborators(): ArrayCollaborators {
    return $this->arrayCollaborators;
  }
  
  public function getCharges(): ArrayCharges {
    return $this->arrayCharges;
  }

}