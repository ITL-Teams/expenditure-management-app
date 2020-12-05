<?php
namespace App\Application\Charge;

use App\Domain\IBudgetRepository;
use App\Domain\Entity\Charge;
use App\Domain\ValueObject\ChargeId;
use App\Domain\ValueObject\CollaboratorId;
use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Date;
use App\Domain\ValueObject\Time;
use App\Domain\ValueObject\BudgetLimit;

class BudgetItemCreator {
  private IBudgetRepository $repository;

  public function __construct(IBudgetRepository $repository) {
    $this->repository = $repository;
  }

  public function invoke(BudgetItemCreatorRequest $request): Charge {
    $budgetId = new BudgetId($request->budgetId);
    $collaboratorId = new CollaboratorId($request->collaboratorId);
    $title = new Title($request->title);
    $amount = new BudgetLimit($request->budgetLimit);
    $predate = \getdate();
    
    $date =  strval($predate->mday).'/'.strval($predate->mon).'/'.strval($predate->year);
    $time =  strval($predate->hours).':'.strval($predate->minutes).'/'.strval($predate->seconds);
    $charge = new Charge(new CollaboratorId($request->collaboratorId), 
                                    new BudgetId($request->budgetId),
                                    new Title($request->title),
                                    new BudgetLimit($request->budgetLimit),
                                    new Date($date),
                                    new Time($time)
                                  );
    $this->repository->budgetItemCreator($charge);
    return $charge;                              
  }

}
