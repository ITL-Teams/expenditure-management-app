<?php
namespace App\Application\BudgetCollaboratorAdder;

class BudgetCollaboratorAdderRequest {
  public string $collaboratorId;
  public string $budgetId;
  public string $collaboratorName;
  public int $budgetPercentage;
}
