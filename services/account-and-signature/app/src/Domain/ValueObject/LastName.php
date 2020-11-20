<?php
namespace App\Domain\ValueObject;

class LastName {
    private string $lastName;

    public function __construct(string $lastName)
    {
        $this->lastName = $lastName;
        $this->lastNameSyntax($lastName);
    }

    private function lastNameSyntax(string $lastName): void
    {
        $valid_word = "/[a-zA-ZÀ-ÖØ-öø-ÿ]+\.?(( |\-)[a-zA-ZÀ-ÖØ-öø-ÿ]+\.?)*/";
        if (preg_match($valid_word, $lastName)) return;
        throw new \Exception($lastName . ' is not valid as lastName');
    }

    public function toString(): string
    {
        return $this->lastName;
    }
}