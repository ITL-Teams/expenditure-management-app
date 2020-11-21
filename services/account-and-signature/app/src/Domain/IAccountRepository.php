<?php
namespace App\Domain;

use App\Domain\Entity\Account;
use App\Domain\Entity\AccountFind;
use App\Domain\Entity\ArrayOfEnterpriseAccountEntities;
use App\Domain\ValueObject\AccountId;

interface IAccountRepository {
  public function find(AccountId $accountId): ?AccountFind;
  public function update(Account $account): bool;
  public function enterpriseFinder(): ArrayOfEnterpriseAccountEntities;
}
