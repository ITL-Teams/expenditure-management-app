<?php
namespace App\Domain;

use App\Domain\Entity\PersonalBudget;
use App\Domain\ValueObject\PersonalBudgetId;
use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\OwnerId;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\Type;
use App\Domain\ValueObject\AMount;
use App\Domain\ValueObject\MountMax;
use App\Domain\ValueObject\MountTotal;


interface IPersonalBudget {
  public function create(PersonalBudget $personalBudget): void;
  public function get(BudgetId $id): ?Budget;
  public function update(Budget $budget): bool;
  public function delete(BudgetId $budget): bool;
  public function createItemBudget(Item $budget): void;
  public function deleteItemBudget(ItemtId $item): bool;
}