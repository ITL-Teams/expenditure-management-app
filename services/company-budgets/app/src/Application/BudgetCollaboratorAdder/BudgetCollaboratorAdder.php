<?php
namespace App\Application\BudgetCollaboratorAdder;

use App\Domain\IBudgetRepository;
use App\Domain\Entity\Collaborator;
use App\Domain\Entity\BudgetQuantities;
use App\Domain\ValueObject\CollaboratorId;
use App\Domain\ValueObject\CollaboratorName;
use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\BudgetPercentage;
use App\Domain\ValueObject\BudgetLimit;
use App\Domain\ValueObject\BudgetQuantity;

class BudgetCollaboratorAdder {
  private IBudgetRepository $repository;

  public function __construct(IBudgetRepository $repository) {
    $this->repository = $repository;
  }

  public function invoke(BudgetCollaboratorAdderRequest $request): Collaborator {
    /* Value Objects */
    $budgetId = new BudgetId($request->budgetId);
    $collaboratorId = new CollaboratorId($request->collaboratorId);
    $budgetPercentage   = new BudgetPercentage($request->budgetPercentage);

    /* Verificar si existe el presupuesto al que se le quiere añadir */
    $budgetExist = $this->repository->budgetFinderId($budgetId);    
    if($budgetExist==false)
      throw new \Exception('The budget does not exist '.$request->budgetId);
    
    /* Se obtiene limite y porcentage asignado de company-budgets */
    $budgetQuantities   = $this->repository->getBudgetQuantities($budgetId);

    /* Se valida que el porcentage a asignar no rebase el porcentage que tiene el presupuesto */
    $totalbudgetPercentage = $budgetQuantities->getPercentage()->toInt() - $budgetPercentage->toInt(); 
    
    if($totalbudgetPercentage < 0)
      throw new \Exception('The percentage to be allocated exceeds the budget '.$budgetPercentage->toInt());

    /* Se verifica si el colaborador ya tiene un porcentage asignado de ese presupuesto */
    $searchCollaborator = $this->repository->searchCollaborator($budgetId,$collaboratorId);
    if($searchCollaborator){
        $col = $this->repository->getCollaborator($budgetId,$collaboratorId);
        $budgetUpdatePercentage = $budgetPercentage->toInt() + $col->getBudgetPercentage()->toInt();
        $budgetCollaborator = new Collaborator($collaboratorId, 
                                                $budgetId,
                                                new CollaboratorName($request->collaboratorName),
                                                new BudgetPercentage($budgetUpdatePercentage)
                                                );
        $flag = $this->repository->budgetCollaboratorUpdated($budgetCollaborator);
        if(!$flag)
          throw new \Exception('an error occurred while allocating the budget');
    }else{
        $budgetCollaborator = new Collaborator($collaboratorId, 
                                                $budgetId,
                                                new CollaboratorName($request->collaboratorName),
                                                $budgetPercentage
                                          );
        $this->repository->budgetCollaboratorAdder($budgetCollaborator);
    }
    /* Fin de validación de colaborador*/

    $budgetUpdated = $this->repository->updatedBudgetQuantities($budgetId,$totalbudgetPercentage);
    if(!$budgetUpdated)
      throw new \Exception('An error occurred while allocating the budget');

    return $budgetCollaborator;
  }

}
