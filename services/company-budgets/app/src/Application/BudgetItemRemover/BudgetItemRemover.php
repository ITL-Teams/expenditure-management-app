<?php
namespace App\Application\BudgetItemRemover;

use App\Domain\IBudgetRepository;
use App\Domain\ValueObject\ChargeId;

class BudgetItemRemover {
  private IBudgetRepository $repository;

  public function __construct(IBudgetRepository $repository) {
    $this->repository = $repository;
  }

  public function invoke(BudgetItemRemoverRequest $request): bool {
    
    $chargeId = new ChargeId($request->chargeId);
    $chargeExist = $this->repository->chargeFinderId($chargeId);
    
    if(!$chargeExist)
      throw new \Exception('The charge does not exist '.$request->chargeId);
    
    
    $budget = $this->repository->budgetItemRemover($chargeId);
    return $budget;
  }

}
