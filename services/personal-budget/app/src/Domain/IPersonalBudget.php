<?php
namespace App\Domain;

use App\Domain\Entity\PersonalBudget;
use App\Domain\ValueObject\PersonalBudgetId;

interface IPersonalBudget {
  public function create(Budget $budget): void;
  public function get(BudgetId $id): ?Budget;
  public function update(Budget $budget): bool;
  public function delete(BudgetId $budget): bool;
  public function createItemBudget(Item $budget): void;
  public function deleteItemBudget(ItemtId $item): bool;
}