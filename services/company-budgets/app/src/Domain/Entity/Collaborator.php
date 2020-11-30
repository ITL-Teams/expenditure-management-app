<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\CollaboratorId;
use App\Domain\ValueObject\CollaboratorName;
use App\Domain\ValueObject\BudgetPercentage;
use App\Domain\ValueObject\BudgetQuantity;

class Collaborator {
  private BudgetId $budgetId;
  private CollaboratorId $collaboratorId;
  private CollaboratorName $collaboratorName;
  private BudgetPercentage $budgetPercentage;
  private BudgetQuantity $budgetQuantity;

  public function __construct(CollaboratorId $collaboratorId,BudgetId $budgetId,
                                CollaboratorName $collaboratorName,BudgetPercentage $budgetPercentage,BudgetQuantity $budgetQuantity) {
    $this->collaboratorId = $collaboratorId;
    $this->budgetId = $budgetId;
    $this->collaboratorName = $collaboratorName;
    $this->budgetPercentage = $budgetPercentage;
    $this->budgetQuantity   = $budgetQuantity;
  }
    
  public function getIdCollaborator(): CollaboratorId {
    return $this->collaboratorId;
  }

  public function getId(): BudgetId {
    return $this->budgetId;
  }

  public function getName(): CollaboratorName {
    return $this->collaboratorName;
  }
  
  public function getBudgetPercentage(): BudgetPercentage {
    return $this->budgetPercentage;
  }

  public function getBudgetQuantity(): BudgetQuantity {
    return $this->budgetQuantity;
  }

}