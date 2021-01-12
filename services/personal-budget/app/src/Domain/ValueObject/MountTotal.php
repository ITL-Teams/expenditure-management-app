<?php
namespace App\Domain\ValueObject;

class MonthTotal {
  private String $month_2;
  
  public function __construct(string $month) {
    $this->month_2 = $month;
    $this->ensureNameOnlyContainsNumbers($month_2);
  }

  private function ensureNameOnlyContainsNumbers(string $value): void {
    $valid_word = "/^([0-9])+$/";
    if(preg_match($valid_word, $value)) return;
      throw new \Exception($value . ' is not valid as name');
  }

  public function toInt(): int {
    return $this->month_2;
  }
}