<?php
namespace App\Domain\Entity;

use App\Domain\Entity\Collaborator;

class ArrayCollaborators {
  private array $budgets;
  
  public function __construct() {
    $this->budgets = [];
  }
    
  public function addBudget(Collaborator $budgetCollaborators){
    \array_push($this->budgets,$budgetCollaborators);
  }
  
  public function getBudgets(): array {
    return $this->budgets;
  }

}