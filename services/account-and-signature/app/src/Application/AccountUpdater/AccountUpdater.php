<?php
namespace App\Application\AccountUpdater;

use App\Domain\IAccountRepository;
use App\Domain\Entity\Account;
use App\Domain\ValueObject\AccountId;
use App\Domain\ValueObject\FirstName;
use App\Domain\ValueObject\LastName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;
use App\Domain\ValueObject\SignatureId;

class AccountUpdater {
  private IAccountRepository $repository;

  public function __construct(IAccountRepository $repository) {
    $this->repository = $repository;
  }

  public function invoke(AccountUpdaterRequest $request): AccountUpdaterResponse {
    $account = new Account(
      new AccountId($request->accountId),
      new FirstName($request->firstName),
      new LastName($request->lastName),
      new Email($request->email),
      $request->password==null?null:new Password($request->password),
      $request->signature==null?null:new SignatureId($request->signature)
    );
    $bool = $this->repository->update($account);
    if(!$bool)
      throw new \Exception(
        'An error ocurred during update'
      );

    $response = new AccountUpdaterResponse;
    $response->accountId = $request->accountId;
    $response->firstName = $request->firstName;
    $response->lastName = $request->lastName;
    $response->email = $request->emai;
    $response->signature = $request->signature;

    return $response;
  }
}
