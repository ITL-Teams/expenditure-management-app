<?php
namespace App\Infraestructure\Controller\BudgetMaster;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\BudgetMaster\BudgetMaster;
use App\Application\BudgetMaster\BudgetMasterRequest;
use App\Application\BudgetMaster\BudgetMasterResponse;
use App\Domain\IBudgetRepository;

class BudgetMasterControllerResponse extends ControllerResponse {  
  private BudgetMaster $service;

  public function init(IBudgetRepository $repository): void {
    $this->service = new BudgetMaster($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {      
    
    try {
      $serviceRequest = new BudgetMasterRequest();
      $serviceRequest->budgetId = $this->params->budgetid;
      $budget = $this->service->invoke($serviceRequest);

      return new JsonResponse([
        'success' => [
          'budget_id' => $budget->budgetId,
          'owner_id' => $budget->ownerId,
          'budget_name' => $budget->budgetName,
          'budget_limit' => $budget->budgetLimit,
          'budget_status' => $budget->budgetStatus,
          'budget_assigned_percentage' => $budget->budgetPercentage,
          'collaborators' => $budget->collaborators,
          'charges' => $budget->charges
        ]
      ]);

    } catch(RequestException | Exception $exeption) {
      return new JsonResponse([
        'error' => [
          'message' => 'Error when searching for the budget',
          'reason' => $exeption->getMessage()
        ]
      ]);
    }
  }
}
