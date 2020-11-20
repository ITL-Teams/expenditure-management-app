<?php
namespace App\Domain\ValueObject;

class AMonth {
  private String $month;
  
  public function __construct(string $month) {
    $this->month = $month;
    $this->ensureNameOnlyContainsNumbers($this->month);
  }

  private function ensureNameOnlyContainsNumbers(string $value): void {
    $valid_word = "/^([0-9])+$/";
    if(preg_match($valid_word, $value)) return;
      throw new \Exception($value . ' is not valid as name');
  }

  public function toInt(): int {
    return $this->month;
  }
}
