<?php
namespace App\Application\BudgetDeleter;

use App\Domain\IBudgetRepository;
use App\Domain\ValueObject\BudgetId;

class BudgetDeleter {
  private IBudgetRepository $repository;

  public function __construct(IBudgetRepository $repository) {
    $this->repository = $repository;
  }

  public function invoke(BudgetDeleterRequest $request): bool {
    
    $budgetSearchId = new BudgetId($request->budgetId);
    $budgetExist = $this->repository->budgetFinderId($budgetSearchId);
    
    if(!$budgetExist)
      throw new \Exception('The budget does not exist '.$request->budget_id);
    
    
    $budget = $this->repository->budgetDeleter($budgetSearchId);
    return $budget;
  }

}
