<?php
namespace App\Domain\ValueObject;

class Time {
  private string $time;
  
  public function __construct(string $time) {
    $this->time = $time;
  }

  public function toString(): string {
    return trim($this->time);
  }
}