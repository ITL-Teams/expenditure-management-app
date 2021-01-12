<?php
namespace App\Application\BudgetItemCreator;

use App\Domain\IPersonalBudget;
use App\Domain\Entity\Charge;
use App\Domain\ValueObject\ChargeId;
use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Date;
use App\Domain\ValueObject\Time;
use App\Domain\ValueObject\AMount;

class BudgetItemCreator {
  private IPersonalBudget $repository;

  public function __construct(IPersonalBudget $repository) {
    $this->repository = $repository;
  }

  public function invoke(BudgetItemCreatorRequest $request): Charge {
    /* Value Objects */
    $budgetId = new BudgetId($request->budgetId);
    $title = new Title($request->title);
    $amount = new AMount($request->amount);
    $date =  date("d").'/'.date("m").'/'.date("y");
    $time =  date("H").':'.date("i").':'.date("s");
    
    /* Se valida que exista el presupuesto */
    $budgetExist = $this->repository->budgetFinderId($budgetId);
    if($budgetExist==false)
      throw new \Exception('The budget does not exist '.$budgetId->toString());

    $charge = new Charge(  new BudgetId($request->budgetId),
                                    new Title($request->title),
                                    new AMount($request->amount),
                                    new Date($date),
                                    new Time($time)
                                  );
    $this->repository->budgetItemCreator($charge);
    return $charge;                              
  }

}