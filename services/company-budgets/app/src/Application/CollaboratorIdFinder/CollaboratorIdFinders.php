<?php
namespace App\Application\CollaboratorIdFinder;

use App\Domain\IBudgetRepository;
use App\Domain\Entity\OwnerBudgets;
use App\Domain\Entity\CollaboratorIdFinder;
use App\Domain\Entity\ArrayOwnerBudgets;
use App\Domain\ValueObject\CollaboratorId;
use App\Application\CollaboratorIdFinder\CollaboratorIdFinderResponse;

class CollaboratorIdFinders {
  private IBudgetRepository $repository;

  public function __construct(IBudgetRepository $repository) {
    $this->repository = $repository;
  }

  public function invoke(CollaboratorIdFinderRequest $request): CollaboratorIdFinderResponse {
      
    $budgetExist = $this->repository->validateCollaborator(new CollaboratorId($request->collaboratorId));    
    
    if(!$budgetExist)
      throw new \Exception('The collaborator does not have an allocated budget '.$request->collaborator_id);

    $budgets = $this->repository->collaboratorIdFinder(new CollaboratorId($request->collaboratorId))->getOwnerBudgets();
    $response = new CollaboratorIdFinderResponse;
    $budgetsFormated = [];
    foreach($budgets as $budget) {
      \array_push($budgetsFormated,[
                                      'budget_id' => $budget->getId()->toString(),
                                      'budget_name' => $budget->getName()->toString()
                                   ]
                  );
    }
    $response->collaboratorId = $request->collaboratorId;
    $response->ownerBudegts = $budgetsFormated;
    return $response;
  }
}
