<?php
namespace App\Application\BudgetItemCreator;

class BudgetItemCreatorRequest {
  public string $budgetId;
  public string $title;
  public int $amount;
}