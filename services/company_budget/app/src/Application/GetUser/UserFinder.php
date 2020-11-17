<?php
namespace App\Application\GetUser;

use App\Domain\IUserRepository;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;

class UserFinder {
  private IUserRepository $repository;

  public function __construct(IUserRepository $repository) {
    $this->repository = $repository;
  }

  public function invoke(UserFinderRequest $request): User {
    $userId = new UserId($request->user_id);
    $user = $this->repository->get($userId);
    if($user == null)
      throw new \Exception('UserNotFoundError: with userId = '.$request->user_id);
    return $user;
  }

}
