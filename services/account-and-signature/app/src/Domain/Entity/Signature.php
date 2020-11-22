<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\SignatureId;

class Signature {
  private SignatureId $id;

  public function __construct(SignatureId $id = null) {
    $this->id = $id != null ? $id : new SignatureId($this->generateSignature());
  }

  private function generateSignature(): string {
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($permitted_chars), 0, 30).time();
  }

  public function getSignature(): SignatureId {
    return $this->id;
  }
}
