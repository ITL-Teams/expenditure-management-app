<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\UserName;

class User {
  private UserId $id;
  private UserName $name;

  public function __construct(UserName $name, UserId $id = null) {
    $this->name = $name;
    $this->id = $id != null ? $id : new UserId($this->generateId());
  }

  private function generateId(): string {
    $random = (float)rand() / (float)getrandmax() * 100;
    settype($random, 'integer');
    $date = new \DateTime();
    return $date->getTimestamp() . $random;
  }

  public function getId(): UserId {
    return $this->id;
  }

  public function getName(): UserName {
    return $this->name;
  }

}
