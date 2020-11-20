<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\FirstName;
use App\Domain\ValueObject\LastName;
use App\Domain\ValueObject\Password;
use App\Domain\ValueObject\SignatureId;
use App\Domain\ValueObject\AccountId;
use App\Domain\ValueObject\EnterpriseAccount;

class AccountFind
{
    private Email $email;
    private FirstName $firstName;
    private LastName $lastName;
    private ?SignatureId $signature;
    private AccountId $accountId;
    private EnterpriseAccount $enterpriseAccount;

    public function __construct(
        AccountId $accountId,
        FirstName $firstName,
        LastName $lastName,
        Email $email,
        SignatureId $signature
        //EnterpriseAccount $enterpriseAccount
    ) {
        $this->accountId = $accountId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->signature = $signature;
        //$this->enterpriseAccount = $enterpriseAccount;
    }

    public function getAccountId(): AccountId
    {
        return $this->accountId;
    }

    public function getFirstName(): FirstName
    {
        return $this->firstName;
    }

    public function getLastName(): LastName
    {
        return $this->lastName;
    }

    public function getPassword(): ?Password
    {
        return $this->password;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getSignatureId(): ?SignatureId
    {
        return $this->signature;
    }

    public function getEnterpriseAccount(): ?EnterpriseAccount
    {
        return $this->enterpriseAccount;
    }
}
