<?php
namespace App\Application\EnterpriseAccountVerifier;

use App\Domain\IAccountRepository;
use App\Domain\ValueObject\AccountId;

class EnterpriseAccountVerifier {
  private IAccountRepository $repository;

  public function __construct(IAccountRepository $repository) {
    $this->repository = $repository;
  }

  public function invoke(EnterpriseAccountVerifierRequest $request): EnterpriseAccountVerifierResponse {    
    $this->repository->verifyAccount(
      new AccountId($request->account_id),
      $request->verify
    );

    $response = new EnterpriseAccountVerifierResponse;
    $response->message = 'The account was '
                            . ($request->verify ? 'verified':'rejected')
                            .' successfully';
    return $response;
  }
}
