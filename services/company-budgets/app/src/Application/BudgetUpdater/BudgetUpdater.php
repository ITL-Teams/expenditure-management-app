<?php
namespace App\Application\BudgetUpdater;

use App\Domain\IBudgetRepository;
use App\Domain\Entity\Budget;
use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\BudgetLimit;

class BudgetUpdater {
  private IBudgetRepository $repository;

  public function __construct(IBudgetRepository $repository) {
    $this->repository = $repository;
  }

  public function invoke(BudgetUpdaterRequest $request): Budget {
    $budgetSearchBudgetId = new BudgetId($request->budgetId);
    $budgetExist = $this->repository->budgetFinderId($budgetSearchBudgetId);
    if($budgetExist==false)
      throw new \Exception('The budget does not exist '.$request->budgetId);

    $budget = new Budget(new BudgetName($request->budgetName),new BudgetLimit($request->budgetLimit),new BudgetId($request->budgetId));
    
    $bool = $this->repository->budgetUpdater($budget);
    
    if(!$bool)
      throw new \Exception(
        'An error ocurred during update'
      );
    return $budget;
  }

}