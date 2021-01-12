<?php

namespace App\Domain\Entity;

use App\Domain\Entity\ArrayOwnerBudgets;
use App\Domain\ValueObject\OwnerId;


class BudgetIdFinder
{
    
    private OwnerId $ownerId;
    private ArrayOwnerBudgets $ownerBudgets;
    

    public function __construct(
        OwnerId $ownerId,
        ArrayOwnerBudgets $ownerBudgets
       
        ) {
        $this->ownerId = $ownerId;
        $this->ownerBudgets = $ownerBudgets;
    }
    public function getOwnerId(): OwnerId
    {
        return $this->ownerId;
    }

    public function getBudgets(): array
    {
        return $this->ownerBudgets;
    }
}
