<?php
namespace App\Application\BudgetIdFinder;

use App\Domain\IBudgetRepository;
use App\Domain\Entity\OwnerBudgets;
use App\Domain\Entity\BudgetIdFinder;
use App\Domain\Entity\ArrayOwnerBudgets;
use App\Domain\ValueObject\OwnerId;
use App\Application\BudgetIdFinder\BudgetIdFinderResponse;

class BudgetIdFinders {
  private IBudgetRepository $repository;

  public function __construct(IBudgetRepository $repository) {
    $this->repository = $repository;
  }

  public function invoke(BudgetIdFinderRequest $request): BudgetIdFinderResponse {
      $budgets = $this->repository->budgetIdFinder(new OwnerId($request->ownerId))->getOwnerBudgets();
      $response = new BudgetIdFinderResponse;
      $budgetsFormated = [];
      foreach($budgets as $budget) {
      \array_push($budgetsFormated,[
                                      'budget_id' => $budget->getId()->toString(),
                                      'budget_name' => $budget->getName()->toString()
                                    ]
                  );
      }
      $response->ownerId = $request->ownerId;
      $response->ownerBudegts = $budgetsFormated;
      return $response;
  }
}
