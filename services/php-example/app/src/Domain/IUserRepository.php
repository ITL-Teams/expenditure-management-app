<?php
namespace App\Domain;

use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;

interface IUserRepository {
  public function create(User $user): void;
  public function get(UserId $id): ?User;
  public function update(User $user): bool;
  public function delete(UserId $id): bool;
}
