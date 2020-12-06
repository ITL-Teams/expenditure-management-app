<?php
namespace App\Application\BudgetMaster;

use App\Domain\IBudgetRepository;
use App\Domain\Entity\ArrayCharges;
use App\Domain\Entity\ArrayCollaborators;
use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\OwnerId;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\BudgetLimit;
use App\Application\BudgetMaster\BudgetMasterResponse;
use App\Application\BudgetMaster\BudgetMasterRequest;

class BudgetMaster {
  private IBudgetRepository $repository;

  public function __construct(IBudgetRepository $repository) {
    $this->repository = $repository;
  }

  public function invoke(BudgetMasterRequest $request): BudgetMasterResponse {
    $budgetId = new BudgetId($request->budgetId); 
    $budgetExist = $this->repository->budgetFinderId($budgetId);    
    if(!$budgetExist)
      throw new \Exception('The budget does not exist '.$request->budgetId); 
    
    $budgets = $this->repository->getBudgets($budgetId);
    $ownerId = $budgets->getOwnerId()->toString();
    $budgetName = $budgets->getName()->toString();
    $budgetLimit = $budgets->getBudgetLimit()->toInt();
    if($budgets->getBudgetPercentage()->toInt()>=25){
      $budgetStatus = "OK";
    }else {
      $budgetStatus = "EXCEEDED";
    }
    $budgetsAssigned = 100 - $budgets->getBudgetPercentage()->toInt();
    
    $collaborators = $this->repository->getCollaborators($budgetId)->getBudgets();
    
    $charges = $this->repository->getCharges($budgetId)->getBudgets();
    $response = new BudgetMasterResponse;
    $collaboratorsFormated = [];
    foreach($collaborators as $collaborator) {
      \array_push($collaboratorsFormated,[
                                      'collaborator_id' => $collaborator->getId()->toString(),
                                      'collaborator_name' => $collaborator->getName()->toString(),
                                      'budget_percentage' => $collaborator->getBudgetPercentage()->toInt()
                                    ]
                  );
    }
    $chargesFormated = [];
    foreach($charges as $charge) {
      \array_push($chargesFormated,[
                                      'charge_id' => $charge->getId()->toString(),
                                      'collaborator_id' => $charge->getCollaboratorId()->toString(),
                                      'title' => $charge->getTitle()->toString(),
                                      'date' => $charge->getDate()->toString(),
                                      'time' => $charge->getTime()->toString(),
                                      'amount' => $charge->getBudgetLimit()->toInt()
                                    ]
                  );
    }
      $response->budgetId = $budgetId->toString();
      $response->ownerId = $ownerId;
      $response->budgetName = $budgetName;
      $response->budgetLimit = $budgetLimit;
      $response->budgetStatus = $budgetStatus;
      $response->budgetPercentage = $budgetsAssigned;
      $response->collaborators = $collaboratorsFormated;
      $response->charges = $chargesFormated;
      return $response;
  }
}
