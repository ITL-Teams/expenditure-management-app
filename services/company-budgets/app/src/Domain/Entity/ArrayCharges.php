<?php
namespace App\Domain\Entity;

use App\Domain\Entity\Charge;

class ArrayCharges {
  private array $items;
  
  public function __construct() {
    $this->items = [];
  }
    
  public function addBudget(Charge $charge){
    \array_push($this->items,$charge);
  }
  
  public function getBudgets(): array {
    return $this->items;
  }
}