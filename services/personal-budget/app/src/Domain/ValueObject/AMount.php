<?php
namespace App\Domain\ValueObject;

class AMount {
  private int $amount;
  
  public function __construct(string $amount) {
    $this->amount = $amount;
    $this->checkQuantity($this->amount);
  }

  private function checkQuantity(int $amount): void {
    if($amount>0) return;
      throw new \Exception(' the amount must be greater than $0');
  }

  public function toInt(): int {
    return $this->amount;
  }
}