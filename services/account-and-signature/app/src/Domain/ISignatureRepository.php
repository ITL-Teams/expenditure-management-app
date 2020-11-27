<?php
namespace App\Domain;

use App\Domain\Entity\Signature;

interface ISignatureRepository {
  public function create(): Signature;
}
