<?php
namespace App\Domain\Entity;

use App\Domain\Entity\ArrayOwnerBudgets;
use App\Domain\ValueObject\CollaboratorId;

class CollaboratorIdFinder {
  private CollaboratorId $collaboratorId;
  private ArrayOwnerBudgets $ownerBudgets;
  
  public function __construct(CollaboratorId $collaboratorId,ArrayOwnerBudgets $ownerBudgets) {
    $this->collaboratorId = $collaboratorId;
    $this->ownerBudgets = $ownerBudgets;
  }
    
  public function getCollaboratorId(): CollaboratorId{
    return $this->collaboratorId;
  }
  
  public function getBudgets(): array {
    return $this->ownerBudgets;
  }

}