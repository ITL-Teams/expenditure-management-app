<?php
namespace App\Domain\Entity;

class ArrayOfEnterpriseAccountEntities {    
    private array $accounts;

    public function __construct() {
      $this->accounts = [];
    }

    public function addAccount(EnterpriseAccountEntity $account) {
      \array_push($this->accounts, $account);
    }

    public function getAccounts(): array {
      return $this->accounts;
    }
}
