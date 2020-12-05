<?php

namespace App\Application\BudgetMaster;

Class BudgetMasterResponse{
    public string $budgetId;
    public string $ownerId;
    public string $budgetName;
    public int $budgetLimit;
    public String $budgetStatus;
    public int $budgetPercentage;
    public array $collaborators;
    public array $charges;
}

