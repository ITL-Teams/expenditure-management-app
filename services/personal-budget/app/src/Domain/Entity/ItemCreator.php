<?php

namespace App\Domain\Entity;


use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\OwnerId;
use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\Type;
use App\Domain\ValueObject\AMount;


class ItemCreator
{
    private AMount $amount;
    private BudgetName $budgetName;
    private OwnerId $ownerId;
    private BudgetId $budgetId;
    private Type $type;

    public function __construct( Type $type, AMount $amount, BudgetName $budgetName, OwnerId $ownerId, BudgetId $budgetId =null) {
        $this->amount = $amount;
        $this->type = $type;
        $this->budgetName = $budgetName;
        $this->ownerId = $ownerId;
        $this->budgetId = $budgetId != null ? $budgetId : new BudgetId($this->generateId());
        
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

    public function getName(): BudgetName
    {
        return $this->budgetName;
    }

    public function getOwnerId(): OwnerId
    {
        return $this->ownerId;
    }

    public function getId(): BudgetId
    {
        return $this->budgetId;
    }
}
