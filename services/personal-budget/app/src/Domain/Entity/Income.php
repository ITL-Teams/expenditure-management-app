<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Type;
use App\Domain\ValueObject\AMount;

class Income
{
    private Type $type;
    private AMount $amount;

    public function __construct( Type $type, AMount $amount ) {
        $this->type = $type;
        $this->amount = $amount;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getAMount(): AMount
    {
        return $this->amount;
    }
 
   
}