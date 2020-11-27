<?php

namespace App\Domain\ValueObject;

class EnterpriseAccount
{
    private bool $value;

    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    public function toBool(): bool
    {
        return $this->value;
    }
}
