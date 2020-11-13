<?php
namespace App\Application\CreateUser;

use App\Domain\IUserRepository;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserName;

class UserCreator {
  private IUserRepository $repository;

  public function __construct(IUserRepository $repository) {
    $this->repository = $repository;
  }

  public function invoke(UserCreatorRequest $request): User {
    $user = new User(new UserName(
      $request->firstName,
      $request->lastName
    ));
    $this->repository->create($user);
    return $user;
  }

}
