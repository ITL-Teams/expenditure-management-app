<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\CollaboratorId;
use App\Domain\Entity\ArrayBudgetsCollaborator;

class BudgetsCollaboratorData {
  private CollaboratorId $collaboratorId;
  private ArrayBudgetsCollaborator $arrayBudgets;

  public function __construct(CollaboratorId $collaboratorId, ArrayBudgetsColaborator $arrayBudgets) {
    $this->collaboratorId = $collaboratorId;
    $this->arrayBudgets = $arrayBudgets;
  }
    
  public function getCollaboratorId(): CollaboratorId {
    return $this->collaboratorId;
  }
  
  public function getBudgets(): ArrayBudgetsCollaborator{
    return $this->arrayBudgets;
  }

}