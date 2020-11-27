<?php
namespace App\Domain;

use App\Domain\Entity\CompanyBudget;
use App\Domain\Entity\Budget;
use App\Domain\Entity\Collaborator;
use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\OwnerId;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\BudgetPercentage;

interface IBudgetRepository {
  public function budgetCreator(CompanyBudget $companyBudget): void;
  public function budgetFinderName(BudgetName $budgetName,OwnerId $ownerId): bool;
  public function budgetFinderId(BudgetId $budgetId): bool;
  public function budgetFinder(BudgetId $budgetId): ?CompanyBudget;
//   public function budgetIdFinder(OwnerId $ownerId): ?ArrayCompanyBudgets;
  public function budgetUpdater(Budget $budget): bool;
  public function budgetDeleter(BudgetId $budgetId): bool;
  public function budgetCollaboratorAdder(Collaborator $collaborator): void;
  public function budgetValidatePercentage(BudgetId $budgetId): int;
//   public function budgetCollaboratorRemover(BudgetId $budgetId,CollaboratorId $collabortatorId): bool;
//   public function budgeCollaboratorIdFinder(CollaboratorId $collaboratorId): ArrrayCollaboratorBudget;
//   public function budgetItemCreatorlete(BudgetId $budgetId,BudgetItem $budgetItem): BudgetItem;
//   public function budgetItemDeleter(ItemId $itemId): bool;
}
