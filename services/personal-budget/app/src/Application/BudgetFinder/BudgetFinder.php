<?php
namespace App\Application\BudgetFinder;

use App\Domain\IPersonalBudget;
use App\Domain\Entity\ArrayOfCharges;
use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\OwnerId;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\AMount;
use App\Application\BudgetFinder\BudgetFinderResponse;
use App\Application\BudgetFinder\BudgetFinderRequest;

class BudgetFinder {
  private IPersonalBudget $repository;

  public function __construct(IPersonalBudget $repository) {
    $this->repository = $repository;
  }

  public function invoke(BudgetFinderRequest $request): BudgetFinderResponse {
    $budgetId = new BudgetId($request->budgetId); 
    $budgetExist = $this->repository->budgetFinderId($budgetId);    
    if(!$budgetExist)
      throw new \Exception('The budget does not exist '.$request->budgetId); 
    
    $budgets = $this->repository->getBudgets($budgetId);
    $ownerId = $budgets->getOwnerId()->toString();
    $budgetName = $budgets->getName()->toString();

    $amount = $budgets->getAMount()->toInt();
    $type = $budgets->getType()->toString();
    $max= $this->repository->getBudgetMax($budgetId);
    $total = $this->repository->getChargesTotal($budgetId);
    $limit=$max*.75;
    
    if($total<$limit){
      $budgetStatus = "OK";
    }else if($total>=$limit && $total<=$max){
      $budgetStatus = "ALMOST_EXCEEDED";
    }else {
      $budgetStatus = "EXCEEDED";
    }
    

    $charges = $this->repository->getCharges($budgetId)->getBudgets();
    $response = new BudgetFinderResponse;

    $chargesFormated = [];
    foreach($charges as $charge) {
      \array_push($chargesFormated,[
                                      'title' => $charge->getTitle()->toString(),
                                      'amount' => $charge->getAMount()->toInt(),
                                      'date' => $charge->getDate()->toString(),
                                      'time' => $charge->getTime()->toString(),
                                      'charge_id' => $charge->getId()->toString()
                                    ]
                  );
    }
      $response->budgetId = $budgetId->toString();
      $response->ownerId = $ownerId;
      $response->budgetName = $budgetName;
      $response->budgetStatus = $budgetStatus;
      $response->amount = $amount;
      $response->type = $type;
      $response->max = $max;
      $response->total = $total;
      $response->charges = $chargesFormated;
      return $response;
  }
}