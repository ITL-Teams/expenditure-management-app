<?php
namespace App\Domain\ValueObject;

class Title {
  private string $title;
  
  public function __construct(string $title) {
    $this->title = $title;
    $this->ensureNameOnlyContainsLettersAndNumbers($title);
  }

  private function ensureNameOnlyContainsLettersAndNumbers(string $value): void {
    $valid_word = "/^([0-9a-zA-Z\s'])+$/";
    if(\preg_match($valid_word, $value)) return;
      throw new \Exception($value . ' is not valid as title');
  }

  public function toString(): string {
    return trim($this->title);
  }
}