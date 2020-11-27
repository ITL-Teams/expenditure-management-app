<?php
namespace App\Domain\ValueObject;

class Type {
  private String $type;
  
  public function __construct(string $type) {
    $this->type = $type;
    $this->ensureNameOnlyContainsLetters($name);
  }


  private function ensureNameOnlyContainsLetters(string $value): void {
    if($type=="ANNUAL" || $type=="MONTHLY") return;
      throw new \Exception($value . ' is not valid as type');
  }

  public function toString(): string {
    return trim($this->type);
  }
}