<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\FirstName;
use App\Domain\ValueObject\LastName;
use App\Domain\ValueObject\SignatureId;
use App\Domain\ValueObject\AccountId;
use App\Domain\ValueObject\EnterpriseAccount;

class EnterpriseAccountEntity
{
    private AccountId $accountId;
    private Email $email;
    private FirstName $firstName;
    private LastName $lastName;
    private SignatureId $signature;
    private EnterpriseAccount $isEnterpriseAccount;

    public function __construct(
      AccountId $accountId,
      Email $email,
      FirstName $firstName,
      LastName $lastName,
      SignatureId $signature,
      EnterpriseAccount $isEnterpriseAccount
    ) {
        $this->accountId = $accountId;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;        
        $this->signature = $signature;
        $this->isEnterpriseAccount = $isEnterpriseAccount;
    }

    public function getAccountId(): AccountId
    {
        return $this->accountId;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getFirstName(): FirstName
    {
        return $this->firstName;
    }

    public function getLastName(): LastName
    {
        return $this->lastName;
    }

    public function getSignature(): SignatureId
    {
        return $this->signature;
    }

    public function isEnterpriseAccount(): EnterpriseAccount
    {
        return $this->isEnterpriseAccount;
    }
}
