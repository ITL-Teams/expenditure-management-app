<?php
namespace App\Domain\Entity;

use App\Domain\Entity\OwnerBudgets;

class ArrayOwnerBudgets {    
    private array $ownerBudgets;

    public function __construct() {
      $this->ownerBudgets = [];
    }

    public function addBudget(OwnerBudgets $oBudgets) {
      \array_push($this->ownerBudgets, $oBudgets);
    }

    public function getOwnerBudgets(): array {
      return $this->ownerBudgets;
    }
}
