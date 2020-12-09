<?php
namespace App\Domain\Entity;

use App\Domain\Entity\BudgetsCollaborator;

class ArrayBudgetsCollaborator {
  private array $budgets;
  
  public function __construct() {
    $this->$budgets = [];
  }
    
  public function addBudget(BudgetsCollaborator $budgetsCollaborators){
    \array_push($this->budgets,$budgetsCollaborators);
  }
  
  public function getBudgets(): array {
    return $this->budgets;
  }

}