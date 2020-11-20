<?php

namespace App\Domain\ValueObject;

class Email 
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
        $this->emailSyntax($email);
    }

    private function emailSyntax(string $email): void
    {
        $valid_word = "/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/";
        if (preg_match($valid_word, $email)) return;
        throw new \Exception($email . ' is not valid as email');
    }

    public function toString(): string
    {
        return $this->email;
    }
}
