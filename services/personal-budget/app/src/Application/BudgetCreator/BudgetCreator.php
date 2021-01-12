<?php
namespace App\Application\BudgetCreator;

use App\Domain\IPersonalBudget;
use App\Domain\Entity\PersonalBudget;
use App\Domain\ValueObject\OwnerId;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\Type;
use App\Domain\ValueObject\AMount;


class BudgetCreator {
  private IPersonalBudget $repository;

  public function __construct(IPersonalBudget $repository) {
    $this->repository = $repository;
  }

  public function invoke(BudgetCreatorRequest $request): PersonalBudget {
    
    $budgetSearchName = new BudgetName($request->budgetName);
    $budgetSearchOwnerId = new OwnerId($request->ownerId);

    $budgetExist = $this->repository->budgetFinderName($budgetSearchName,$budgetSearchOwnerId);
    
    if($budgetExist)
      throw new \Exception('There is already as budget with the same name '.$request->budget_name);
    
    
    $budget = new PersonalBudget(new Type($request->type),
                                new AMount($request->amount),
                                new BudgetName($request->budgetName), 
                                new OwnerId($request->ownerId)
              );
    $this->repository->budgetCreator($budget);
    return $budget;
  }

}
