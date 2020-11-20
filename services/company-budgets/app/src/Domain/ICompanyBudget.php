<?php
namespace App\Domain;

use App\Domain\Entity\CompanyBudget;
use App\Domain\Entity\ItemBudget;
use App\Domain\ValueObject\CompanyBudgetId;


interface ICompanyBudget {
  public function BudgetCreator(CompanyBudget $cBudget): void;
  public function BudgetFinder(): ?Budget;
  public function BudgetIdFinder(): ?Array;
  public function BudgetUpdater(CompanyBudget $cBudget): bool;
  public function BudgetDeleter(CompanyBudgetId $CompanyBudgetId): bool;
  public function BudgetCollaboratorAdder(CompanyBudgetId $CompanyBudgetId): bool;
  public function BudgetCollaboratorRemover(CompanyBudgetId $CompanyBudgetId): bool;
  public function BudgeCollaboratorIdFinder(UserId $id): ?User;
  public function BudgetItemCreator(ItemBudget $iBudget): void;
  public function BudgetItemDeleter(ItemBudget $iBudget): bool;
}
