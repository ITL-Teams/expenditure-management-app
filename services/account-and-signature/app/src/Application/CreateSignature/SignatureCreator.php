<?php
namespace App\Application\CreateSignature;

use App\Domain\ISignatureRepository;
use App\Domain\Entity\Signature;

class SignatureCreator {
  private ISignatureRepository $repository;

  public function __construct(ISignatureRepository $repository) {
    $this->repository = $repository;
  }

  public function invoke(SignatureCreatorRequest $request): Signature {
    $Signature = new Signature(
      // values
    );
    $this->repository->create($Signature);
    return $Signature;
  }
}
