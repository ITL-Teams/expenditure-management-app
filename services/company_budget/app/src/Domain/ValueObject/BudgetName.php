<?php
namespace App\Domain\ValueObject;

class BudgetName {
  private string $name;
  
  public function __construct(string $name) {
    $this->name = $name;
    $this->ensureNameOnlyContainsLetters($name);
  }

  private function ensureNameOnlyContainsLetters(string $value): void {
    $valid_word = "/^([a-zA-Z/s'])+$/";
    if(preg_match($valid_word, $value)) return;
      throw new \Exception($value . ' is not valid as name');
  }

  public function toString(): string {
    return $this->trim(name);
  }
}