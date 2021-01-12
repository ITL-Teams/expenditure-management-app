<?php
namespace App\Application\BudgetFinder;

use App\Domain\IBudgetRepository;
use App\Domain\Entity\CompanyBudget;
use App\Domain\ValueObject\BudgetId;

class BudgetFinder {
  private IBudgetRepository $repository;

  public function __construct(IBudgetRepository $repository) {
    $this->repository = $repository;
  }

  public function invoke(BudgetFinderRequest $request): CompanyBudget {
    $budgetId = new BudgetId($request->budget_id);
    $user = $this->repository->get($userId);
    if($user == null)
      throw new \Exception('UserNotFoundError: with userId = '.$request->user_id);
    return $user;
  }

}
