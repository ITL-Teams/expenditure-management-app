<?php
namespace App\Domain\ValueObject;

class StringValueObject {  
  private string $value;

  public function __construct(string $value) {
    $this->value = $value;
  }

  public function toString(): string {
    return $this->value;
  }

}
