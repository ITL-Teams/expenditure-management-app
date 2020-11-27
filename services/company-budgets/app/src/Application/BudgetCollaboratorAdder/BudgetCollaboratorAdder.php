<?php
namespace App\Application\BudgetCollaboratorAdder;

use App\Domain\IBudgetRepository;
use App\Domain\Entity\Collaborator;
use App\Domain\ValueObject\CollaboratorId;
use App\Domain\ValueObject\CollaboratorName;
use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\BudgetPercentage;

class BudgetCollaboratorAdder {
  private IBudgetRepository $repository;

  public function __construct(IBudgetRepository $repository) {
    $this->repository = $repository;
  }

  public function invoke(BudgetCollaboratorAdderRequest $request): Collaborator {
    $budgetTotalPercentage = new BudgetId($request->budgetId);
    $budgetTotal = $this->repository->budgetValidatePercentage($budgetTotalPercentage);

    if(($budgetTotal - $request->budgetPercentage)==0)
      throw new \Exception('the percentage exceeds the budget '.$request->budget_percentage);
    
    $budgetCollaborator = new Collaborator(new CollaboratorId($request->collaboratorId), 
                                new BudgetId($request->budgetId),
                                new CollaboratorName($request->collaboratorName),
                                new BudgetPercentage($request->budgetPercentage)
              );
    $budgetUpdatePercentage = new BudgetPercentage($request->budgetPercentage);
    $budgetUpdated = $this->repository->updatedBudgetPercentage($budgetTotalPercentage,$budgetUpdatePercentage);

    if(!$budgetUpdated)
      throw new \Exception('an error occurred while allocating the budget');

    $this->repository->budgetCollaboratorAdder($budgetCollaborator);
    return $budget;
  }

}
