<?php
namespace App\Application\Charge;

class BudgetItemCreatorRequest {
  public string $collaboratorId;
  public string $budgetId;
  public string $title;
  public int $budgetLimit;
}
