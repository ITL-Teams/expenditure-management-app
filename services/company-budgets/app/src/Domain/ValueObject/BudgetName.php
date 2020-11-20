<?php
namespace App\Domain\ValueObject;

class BudgetName {
  private string $name;
  
  public function __construct(string $name) {
    $this->name = $name;
    $this->ensureNameOnlyContainsLettersAndNumbers($name);
  }

  private function ensureNameOnlyContainsLettersAndNumbers(string $value): void {
    $valid_word = "/^([0-9a-zA-Z/s'])+$/";
    if(preg_match($valid_word, $value)) return;
      throw new \Exception($value . ' is not valid as name');
  }

  public function toString(): string {
    return $this->trim(name);
  }
}