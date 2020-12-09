<?php
namespace App\Application\BudgetUpdater;

use App\Domain\IPersonalBudget;
use App\Domain\Entity\Budget;
use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\AMount;
use App\Domain\ValueObject\Type;

class BudgetUpdater {
  private IPersonalBudget $repository;

  public function __construct(IPersonalBudget $repository) {
    $this->repository = $repository;
  }

  public function invoke(BudgetUpdaterRequest $request): Budget {
    $budgetSearchBudgetId = new BudgetId($request->budgetId);
    
    $budgetExist = $this->repository->budgetFinderId($budgetSearchBudgetId);
    
    if($budgetExist==false)
      throw new \Exception('The budget does not exist '.$request->budgetId);

    $budget = new Budget(new BudgetName($request->budgetName),
                          new AMount($request->amount),
                          new Type($request->type),
                          new BudgetId($request->budgetId));
                          
    $bool = $this->repository->budgetUpdater($budget);
    
    if(!$bool)
      throw new \Exception(
        'An error ocurred during update'
      );
    return $budget;
  }

}