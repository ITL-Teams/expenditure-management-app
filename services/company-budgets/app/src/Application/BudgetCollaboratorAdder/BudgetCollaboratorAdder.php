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
    
    $budgetExist = $this->repository->budgetFinderId($budgetId);    
    if($budgetExist==false)
      throw new \Exception('The budget does not exist '.$request->budgetId);
    
      $collaboratorId = new CollaboratorId($request->collaboratorId);
    $budgetPercentage = new BudgetPercentage($request->budgetPercentage);
    /* Se obtienen cantidades a actualizar */
    $budgetQuantities = $this->repository->getBudgetQuantities($budgetId);
    $totalbudgetPercentage = $budgetQuantities->getPercentage()->toInt() - $budgetPercentage->toInt(); 
    $budgetQuantity = ($budgetQuantities->getBudgetLimit()->toInt() * $budgetPercentage->toInt())/100;
    $totalbudgetLimit = $budgetQuantities->getBudgetLimit()->toInt() - $budgetQuantity;
    
    if($totalbudgetPercentage < 0)
      throw new \Exception('the percentage exceeds the budget '.$budgetPercentage->toInt());
    
    $budgetUpdateQuantities = new BudgetQuantities(new BudgetPercentage($totalbudgetPercentage)
                                                    ,new BudgetLimit($totalbudgetLimit)
                                                  );
    $budgetUpdated = $this->repository->updatedBudgetQuantities($budgetId,$budgetUpdateQuantities);
    if(!$budgetUpdated)
      throw new \Exception('an error occurred while allocating the budget');
    /* Se verifica si el colaborador ya tiene un porcentage asignado de ese presupuesto */
    $searchCollaborator = $this->repository->searchCollaborator($budgetId,$collaboratorId);
    if($searchCollaborator){
        $col = $this->repository->getCollaborator($budgetId,$collaboratorId);
        $budgetUpdatePercentage = $budgetPercentage->toInt() + $col->getBudgetPercentage()->toInt();
        $budgetUpdateQuantity = $budgetQuantity + $col->getBudgetQuantity()->toInt();
        $budgetCollaborator = new Collaborator($collaboratorId, 
                                                $budgetId,
                                                new CollaboratorName($request->collaboratorName),
                                                new BudgetPercentage($budgetUpdatePercentage),
                                                new BudgetQuantity($budgetUpdateQuantity)
                                                );
        $flag = $this->repository->budgetCollaboratorUpdated($budgetCollaborator);
        if(!$flag)
          throw new \Exception('an error occurred while allocating the budget');
    }else{
        $budgetCollaborator = new Collaborator($collaboratorId, 
                                                $budgetId,
                                                new CollaboratorName($request->collaboratorName),
                                                $budgetPercentage,
                                                new BudgetQuantity($budgetQuantity)
                                          );
        $this->repository->budgetCollaboratorAdder($budgetCollaborator);
    }
    /* Fin de validación de colaborador*/
    return $budgetCollaborator;
  }

}
