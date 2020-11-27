<?php
namespace App\Domain\ValueObject;

class BudgetPercentage {
  private int $amount;
  
  public function __construct(string $amount) {
    $this->amount = $amount;
    $this->checkQuantity($this->amount);
  }

  private function checkQuantity(int $amount): void {
    if($amount>0 && $amount <100) return;
      throw new \Exception(' the percentage must be greater than 0 and less than 100 ');
  }

  public function toInt(): int {
    return $this->amount;
  }
}