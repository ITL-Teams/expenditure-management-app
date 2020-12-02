<?php
namespace App\Domain\ValueObject;

class Time {
  private string $time;
  
  public function __construct(string $time) {
    $this->date = $time;
    $this->ensureNameOnlyContainsLettersAndNumbers($time);
  }

  private function ensureNameOnlyContainsLettersAndNumbers(string $value): void {
    $valid_word = "/^([^a-zA-Z])+$/";
    if(\preg_match($valid_word, $value)) return;
      throw new \Exception($value . ' is not valid as date');
  }

  public function toString(): string {
    return trim($this->time);
  }
}