<?php
namespace App\Domain;

use App\Domain\Entity\Account;
use App\Domain\ValueObject\AccountId;

interface IAccountRepository {
  //public function get(AccountId $accountId): ?Account;
  public function update(Account $account): bool;
  //public function enterpriseUpdate(Account $account): bool;
  //public function verify(Account $account): bool;
}
