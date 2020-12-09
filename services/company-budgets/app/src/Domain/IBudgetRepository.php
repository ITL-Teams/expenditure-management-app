<?php
namespace App\Domain;

use App\Domain\Entity\CompanyBudget;
use App\Domain\Entity\Budget;
use App\Domain\Entity\Charge;
use App\Domain\Entity\Collaborator;
use App\Domain\Entity\BudgetQuantities;
use App\Domain\Entity\ArrayOwnerBudgets;
use App\Domain\Entity\ArrayCollaborators;
use App\Domain\Entity\ArrayCharges;
use App\Domain\Entity\Budgets;
use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\ChargeId;
use App\Domain\ValueObject\CollaboratorId;
use App\Domain\ValueObject\OwnerId;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\BudgetPercentage;
use App\Domain\ValueObject\Title;

interface IBudgetRepository {
  public function budgetCreator(CompanyBudget $companyBudget): void;
  public function budgetFinderName(BudgetName $budgetName,OwnerId $ownerId): bool;
  public function budgetFinderId(BudgetId $budgetId): bool;
  public function budgetFinder(BudgetId $budgetId): ?CompanyBudget;
  public function budgetUpdater(Budget $budget): bool;
  public function budgetDeleter(BudgetId $budgetId): bool;
  public function budgetCollaboratorAdder(Collaborator $collaborator): void;
  public function getBudgetQuantities(BudgetId $budgetId): BudgetQuantities;
  public function budgetCollaboratorRemover(BudgetId $budgetId,CollaboratorId $collabortatorId): bool;
  public function searchBudgetCollaborator(BudgetId $budgetId,CollaboratorId $collabortatorId): bool;
  public function searchQuantitiesCollaborator(BudgetId $budgetId,CollaboratorId $collabortatorId): BudgetQuantities;
  public function updatedBudgetQuantities(BudgetId $budgetId,Int $budgetPercentage): bool;
  public function searchCollaborator(BudgetId $budgetId,CollaboratorId $collaboratorId): bool;
  public function budgetCollaboratorUpdated(Collaborator $collaborator): bool;
  public function getCollaborator(BudgetId $budgetId,CollaboratorId $collaboratorId): Collaborator;
  public function budgetIdFinder(OwnerId $ownerId): ArrayOwnerBudgets;
  public function collaboratorIdFinder(CollaboratorId $CollaboratorId): ArrayOwnerBudgets;
  public function chargeExists(CollaboratorId $CollaboratorId,BudgetId $budgetId,Title $title):bool;
  public function budgetItemCreator(Charge $charge):void;
//   public function budgetItemDeleter(ItemId $itemId): bool;
  public function getCollaborators(BudgetId $budgetId):ArrayCollaborators;
  public function getCharges(BudgetId $budgetId):ArrayCharges;
  public function getBudgets(BudgetId $budgetId):Budgets;
  public function chargeFinderId(ChargeId $chargeId): bool;
  public function budgetItemRemover(ChargeId $chargeId): bool;
}
