<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\FirstName;
use App\Domain\ValueObject\LastName;
use App\Domain\ValueObject\Password;
use App\Domain\ValueObject\SignatureId;
use App\Domain\ValueObject\AccountId;

class Account
{
    private Email $email;
    private FirstName $firstName;
    private LastName $lastName;
    private Password $password;
    private SignatureId $signature;
    private AccountId $accountId;

    public function __construct(
        AccountId $accountId,
        FirstName $firstName,
        LastName $lastName,
        Password $password,
        Email $email,
        SignatureId $signature
    ) {
        $this->accountId = $accountId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
        $this->email = $email;
        $this->signature = $signature;
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

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getSignatureId(): SignatureId
    {
        return $this->signature;
    }
}
