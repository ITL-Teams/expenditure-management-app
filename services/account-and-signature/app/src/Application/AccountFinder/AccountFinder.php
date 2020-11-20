<?php

namespace App\Application\AccountFinder;

use App\Domain\IAccountRepository;
use App\Domain\Entity\AccountFind;
use App\Domain\ValueObject\AccountId;

class AccountFinder
{
  private IAccountRepository $repository;

  public function __construct(IAccountRepository $repository)
  {
    $this->repository = $repository;
  }

  public function invoke(AccountFinderRequest $request): AccountFind
  {
    $accountId = new AccountId($request->accountId);
    $account = $this->repository->find($accountId);
    if ($account == null)
      throw new \Exception(
        'An error occurred during search'
      );

    // $response = new AccountFinderResponse;
    // $response->accountId = $account->accountId;
    // $response->firstName = $account->firstName;
    // $response->lastName = $account->lastName;
    // $response->email = $account->emai;
    // $response->signature = $account->signature;
    // $response->enterpriseAccount = $account->enterpriseAccount;

    return $account;
  }
}
