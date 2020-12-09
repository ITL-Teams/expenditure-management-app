<?php
namespace App\Domain\ValueObject;

class BudgetStatus {
  private String $status;
  
  public function __construct(string $status) {
    $this->status = $status;
    $this->ensureTypeOnlyContainsLetters($status);
  }


  private function ensureTypeOnlyContainsLetters(string $value): void {
      if($value=="OK" || $value=="ALMOST_EXCEEDED" || $value=="EXCEEDED") return;
      throw new \Exception($value . ' is not valid as status');
  }

  public function toString(): string {
    return trim($this->status);
  }
}