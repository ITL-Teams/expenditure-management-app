<?php
namespace App\Domain\ValueObject;

class Type {
  private String $type;
  
  public function __construct(string $type) {
    $this->type = $type;
    $this->ensureTypeOnlyContainsLetters($type);
  }


  private function ensureTypeOnlyContainsLetters(string $value): void {
      if($value=="ANNUAL" || $value=="MONTHLY") return;
      throw new \Exception($value . ' is not valid as type');
  }

  public function toString(): string {
    return trim($this->type);
  }
}