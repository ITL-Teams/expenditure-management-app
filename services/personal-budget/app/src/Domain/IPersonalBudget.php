<?php
namespace App\Domain;

use App\Domain\Entity\PersonalBudget;
use App\Domain\Entity\Budget;
use App\Domain\Entity\Income;
use App\Domain\Entity\Charge;
use App\Domain\Entity\ArrayOwnerBudgets;
use App\Domain\Entity\OwnerBudgets;
use App\Domain\ValueObject\PersonalBudgetId;
use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\OwnerId;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\MountMax;
use App\Domain\ValueObject\MountTotal;
use App\Domain\ValueObject\ChargeId;
use App\Domain\ValueObject\Title;
use App\Domain\Entity\Budgets;
use App\Domain\Entity\ArrayOfCharges;

interface IPersonalBudget {
  public function budgetCreator(PersonalBudget $personalBudget): void;
  public function budgetFinderName(BudgetName $budgetName,OwnerId $ownerId): bool;
  public function budgetIdFinder(OwnerId $ownerId): ArrayOwnerBudgets;
  public function budgetUpdater(Budget $budget): bool;
  public function budgetDeleter(BudgetId $budgetId): bool;
  public function budgetItemCreator(Charge $charge):void;
  public function chargeFinderId(ChargeId $chargeId): bool;
  public function budgetItemDeleter(ChargeId $chargeId): bool;
  public function chargeExists(BudgetId $budgetId,Title $title):bool;
  public function getBudgets(BudgetId $budgetId):Budgets;
  public function getCharges(BudgetId $budgetId):ArrayOfCharges;
  public function budgetFinder(BudgetId $budgetId): ?PersonalBudget;
}