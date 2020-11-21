<?php
namespace App\Application\EnterpriseAccountFinder;

use App\Domain\IAccountRepository;

class EnterpriseAccountFinder {
  private IAccountRepository $repository;

  public function __construct(IAccountRepository $repository) {
    $this->repository = $repository;
  }

  public function invoke(EnterpriseAccountFinderRequest $request): EnterpriseAccountFinderResponse {    
    $accounts = $this->repository->enterpriseFinder()->getAccounts();
    $response = new EnterpriseAccountFinderResponse;

    $accountsFormated = [];
    foreach($accounts as $account) {
      array_push($accountsFormated, [
        'account_id' => $account->getAccountId()->toString(),
        'email' => $account->getEmail()->toString(),
        'firstName' => $account->getFirstName()->toString(),
        'lastName' => $account->getLastName()->toString(),
        'signature' => $account->getSignature()->toString(),
        'enterprise_account' => $account->isEnterpriseAccount()->toBool()
      ]);
    }

    $response->accounts = $accountsFormated;
    return $response;
  }
}
