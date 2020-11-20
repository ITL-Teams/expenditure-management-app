<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\AMount;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\MountMax;
use App\Domain\ValueObject\MountTotal;
use App\Domain\ValueObject\OwnerId;
use App\Domain\ValueObject\CompanyBudgetId;

class CompanyBudget
{
    private AMount $amount;
    private BudgetName $budgetName;
    private MountMax $mountMax;
    private MountTotal $mountTotal;
    private OwnerId $ownerId;
    private CompanyBudgetId $CompanyBudgetId;

    public function __construct(
        AMount $amount,
        BudgetName $budgetName,
        MountMax $mountMax,
        MountTotal $mountTotal,
        OwnerId $ownerId = null,
        CompanyBudgetId $CompanyBudgetId =null
    ) {
        $this->amount = $amount;
        $this->budgetName = $budgetName;
        $this->mountMax = $mountMax;
        $this->mountTotal = $mountTotal;
        $this->ownerId = $ownerId;
        $this->CompanyBudgetId = $CompanyBudgetId != null ? $CompanyBudgetId : new CompanyBudgetId($this->generateId());
        
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

    public function getCompanyBudgetId(): PersonalBudgetId
    {
        return $this->CompanyBudgetId;
    }
}
