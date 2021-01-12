<?php
namespace App\Application\BudgetUpdater;

class BudgetUpdaterRequest {
  public string $budgetId;
  public string $budgetName;
  public int $amount;
  public string $type;
}
