<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\AMount;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\MountMax;
use App\Domain\ValueObject\MountTotal;
use App\Domain\ValueObject\OwnerId;
use App\Domain\ValueObject\PersonalBudgetId;
use App\Domain\ValueObject\Type;


class PersonalBudget
{
    private AMount $amount;
    private BudgetName $budgetName;
    private MountMax $mountMax;
    private MountTotal $mountTotal;
    private OwnerId $ownerId;
    private PersonalBudgetId $personalBudgetId;
    private Type $type;

    public function __construct(
        AMount $amount,
        Type $type,
        BudgetName $budgetName,
        MountMax $mountMax,
        MountTotal $mountTotal,
        OwnerId $ownerId = null,
        PersonalBudgetId $personalBudgetId =null
    ) {
        $this->amount = $amount;
        $this->type = $amount;
        $this->budgetName = $budgetName;
        $this->mountMax = $mountMax;
        $this->mountTotal = $mountTotal;
        $this->ownerId = $ownerId;
        $this->personalBudgetId = $personalBudgetId != null ? $personalBudgetId : new PersonalBudgetId($this->generateId());
        
    }
    private function generateId(): string {
        $random = (float)rand() / (float)getrandmax() * 100;
        settype($random, 'integer');
        $date = new \DateTime();
        return $date->getTimestamp() . $random;
      }

    public function getAMount(): AMount
    {
        return $this->amount;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getBudgetName(): BudgetName
    {
        return $this->budgetName;
    }

    public function getMountMax(): MountMax
    {
        return $this->mountMax;
    }

    public function getMountTotal(): MountTotal
    {
        return $this->mountTotal;
    }

    public function getOwnerId(): OwnerId
    {
        return $this->ownerId;
    }

    public function getPersonalBudgetId(): PersonalBudgetId
    {
        return $this->personalBudgetId;
    }
}
