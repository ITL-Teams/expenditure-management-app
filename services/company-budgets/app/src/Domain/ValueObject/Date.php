<?php
namespace App\Domain\ValueObject;

class Date {
  private string $date;
  
  public function __construct(string $date) {
    $this->date = $date;
    $this->ensureNameOnlyContainsLettersAndNumbers($date);
  }

  private function ensureNameOnlyContainsLettersAndNumbers(string $value): void {
    $valid_word = "/^([^a-zA-Z])+$/";
    if(\preg_match($valid_word, $value)) return;
      throw new \Exception($value . ' is not valid as date');
  }

  public function toString(): string {
    return trim($this->date);
  }
}