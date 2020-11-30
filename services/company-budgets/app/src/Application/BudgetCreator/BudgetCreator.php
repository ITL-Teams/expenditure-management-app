<?php
namespace App\Application\BudgetCreator;

use App\Domain\IBudgetRepository;
use App\Domain\Entity\CompanyBudget;
use App\Domain\ValueObject\OwnerId;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\BudgetLimit;

class BudgetCreator {
  private IBudgetRepository $repository;

  public function __construct(IBudgetRepository $repository) {
    $this->repository = $repository;
  }

  public function invoke(BudgetCreatorRequest $request): CompanyBudget {
    
    $budgetSearchName = new BudgetName($request->budgetName);
    $budgetSearchOwnerId = new OwnerId($request->ownerId);
    $budgetExist = $this->repository->budgetFinderName($budgetSearchName,$budgetSearchOwnerId);
    
    if($budgetExist)
      throw new \Exception('There is already as budget with the same name '.$request->budget_name);
    
    
    $budget = new CompanyBudget(new BudgetName($request->budgetName), 
                                new OwnerId($request->ownerId),
                                new BudgetLimit($request->budgetLimit)
              );
    $this->repository->budgetCreator($budget);
    return $budget;
  }

}
