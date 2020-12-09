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
    /* Value Objects */
    $budgetId = new BudgetId($request->budgetId);
    $collaboratorId = new CollaboratorId($request->collaboratorId);
    $title = new Title($request->title);
    $amount = new BudgetLimit($request->budgetLimit);
    $date =  date("d").'/'.date("m").'/'.date("y");
    $time =  date("H").':'.date("i").':'.date("s");
    
    /* Se valida que exista el presupuesto */
    $budgetExist = $this->repository->budgetFinderId($budgetId);
    if($budgetExist==false)
      throw new \Exception('The budget does not exist '.$budgetId->toString());
    
    /* Se valida que el colaborador tenga el presupuesto asignado */
    $budgetExist = $this->repository->searchBudgetCollaborator($budgetId,$collaboratorId);    
    if(!$budgetExist)
      throw new \Exception('This budget is not assigned to this collaborator '.$budgetId->toString());

    /* Se valida que el colaborador aún tenga presupuesto para crear el cargo */
      /* 1. se obtiene el limite del presupuesto */
    $budgetQuantities   = $this->repository->getBudgetQuantities($budgetId);
      /* 2. se valida que el monto del cargo a crear no rebase el limite total que tiene el presupuesto */
    $totalbudgetLimit = $budgetQuantities->getBudgetLimit()->toInt(); 
    if($amount->toInt() > $totalbudgetLimit)
      throw new \Exception('The amount of the charge is beyond the budget');
     
      /* 3. se valida que el monto del cargo a crear no rebase el porcentage que se le asigno al colaborador*/
    $dataCollaborator = $this->repository->getCollaborator($budgetId,$collaboratorId);
    $percentageCollaborator = $dataCollaborator->getBudgetPercentage()->toInt();
    $percentage = ($totalbudgetLimit * $percentageCollaborator) / 100;
    if($amount->toInt() > $percentage)
      throw new \Exception('The amount of the charge exceeds the limit of the percentage of the budget');

      /* 4. Se valida que el monto del cargo a crear más los cargos ya creados por el colaborador */
      /* 4. No rebasen monto del porcentage que le fue asignado */
    $chargesCollaborator = $this->repository->getChargesCollaborator($budgetId,$collaboratorId);
    $totalAmount = $amount->toInt() + $chargesCollaborator;
    if($totalAmount > $percentage)
      throw new \Exception('The amount of the charge exceeds the limit of the percentage of the budget');

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
