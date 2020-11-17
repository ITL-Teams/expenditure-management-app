<?php
namespace App\Domain\ValueObject;

class UserName {
  private string $firstName;
  private string $lastName;

  public function __construct(string $firstName, string $lastName) {
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->ensureNameOnlyContainsLetters($firstName);
    $this->ensureNameOnlyContainsLetters($lastName);
  }

  private function ensureNameOnlyContainsLetters(string $value): void {
    $valid_word = "/^([a-zA-Z/s'])+$/";
    if(preg_match($valid_word, $value)) return;
      throw new \Exception($value . ' is not valid as name');
  }

  public function toString(): string {
    return $this->firstName . ' ' . $this->lastName;
  }
}
