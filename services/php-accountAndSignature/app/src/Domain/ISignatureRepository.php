<?php
namespace App\Domain;

use App\Domain\Entity\Signature;
use App\Domain\ValueObject\SignatureId;

interface ISignatureRepository {
  public function create(Signature $signature): void;
}
