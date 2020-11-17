<?php
namespace App\Domain;

use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;

interface IUserRepository {
  public function create(Budget $budget): void;
  public function get(BudgetId $id): ?Budget;
  public function update(Budget $budget): bool;
  public function delete(BudgetId $budget): bool;
  public function addCollaborator(CollaboratorId $id): void;
  public function removeCollaborator(CollaboratorId $id): bool;
  public function getCollaborator(CollaboratorId $id): bool;
  public function createItemCollaborator(Item $budget): void;
  public function deleteItemCollaborator(ItemtId $item): bool;
}