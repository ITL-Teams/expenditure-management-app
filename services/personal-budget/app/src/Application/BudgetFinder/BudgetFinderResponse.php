<?php

namespace App\Application\BudgetFinder;

Class BudgetFinderResponse{
    public string $budgetId;
    public string $ownerId;
    public string $budgetName;
    public int $amount;
    public String $budgetStatus;
    public int $max;
    public int $total;
    public array $charges;
}