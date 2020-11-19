<?php
namespace App\Domain\ValueObject;

class FirstName extends StringValueObject {
    private string $firstName;

    public function __construct(string $firstName)
    {
        $this->firstName = $firstName;
        $this->firstNameSyntax($firstName);
    }

    private function firstNameSyntax(string $firstName): void
    {
        $valid_word = "/[a-zA-ZÀ-ÖØ-öø-ÿ]+\.?(( |\-)[a-zA-ZÀ-ÖØ-öø-ÿ]+\.?)*/";
        if (preg_match($valid_word, $firstName)) return;
        throw new \Exception($firstName . ' is not valid as firstName');
    }

    public function toString(): string
    {
        return $this->firstName;
    }
}