<?php

namespace App\Application\CreateSignature;

use App\Domain\ISignatureRepository;
use App\Domain\Entity\Signature;
use App\Domain\ValueObject\SignatureId;

class SignatureCreator
{

  public function invoke(): SignatureCreatorResponse
  {
    $response = new SignatureCreatorResponse;
    $signature = new Signature();
    $response->signature = $signature->getSignature();
    return $response;
  }
}
