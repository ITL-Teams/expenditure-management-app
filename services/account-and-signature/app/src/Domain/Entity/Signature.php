<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\SignatureId;

class Signature {
  private SignatureId $id;

  public function __construct(SignatureId $id = null) {
    $this->id = $id != null ? $id : new SignatureId($this->generateId());
  }

  private function generateId(): string {
    $random = (float)rand() / (float)getrandmax() * 100;
    settype($random, 'integer');
    $date = new \DateTime();
    return $date->getTimestamp() . $random;
  }

  public function getId(): SignatureId {
    return $this->id;
  }
}
