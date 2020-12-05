<?php
namespace App\Domain\ValueObject;

class Date {
  private string $date;
  
  public function __construct(string $date) {
    $this->date = $date;
  }
  
  public function toString(): string {
    return trim($this->date);
  }
}