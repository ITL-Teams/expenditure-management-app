<?php

namespace App\Domain\ValueObject;

class Password
{
    private string $password;

    public function __construct(string $password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function toString(): string
    {
        return $this->firstName;
    }
}
