<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\SignatureId;

class Signature {
  private SignatureId $id;

  public function __construct(SignatureId $id = null) {
    $this->id = $id != null ? $id : new SignatureId($this->generateId());
  }

  private function generateId(): string {
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return $signature->substr(str_shuffle($permitted_chars), 0, 20);
  }

  public function getId(): SignatureId {
    return $this->id;
  }
}
