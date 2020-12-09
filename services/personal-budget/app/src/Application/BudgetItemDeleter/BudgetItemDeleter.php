<?php
namespace App\Application\BudgetItemDeleter;

use App\Domain\IPersonalBudget;
use App\Domain\ValueObject\ChargeId;

class BudgetItemDeleter {
  private IPersonalBudget $repository;

  public function __construct(IPersonalBudget $repository) {
    $this->repository = $repository;
  }

  public function invoke(BudgetItemDeleterRequest $request): bool {
    
    $chargeId = new ChargeId($request->chargeId);
    $chargeExist = $this->repository->chargeFinderId($chargeId);
    
    if(!$chargeExist)
      throw new \Exception('The charge does not exist '.$request->chargeId);
    
    
    $budget = $this->repository->budgetItemDeleter($chargeId);
    return $budget;
  }

}