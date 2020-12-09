<?php
namespace App\Infraestructure\Controller\BudgetFinder;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\BudgetFinder\BudgetFinder;
use App\Application\BudgetFinder\BudgetFinderRequest;
use App\Application\BudgetFinder\BudgetFinderResponse;
use App\Domain\IPersonalBudget;

class BudgetFinderControllerResponse extends ControllerResponse {  
  private BudgetFinder $service;

  public function init(IPersonalBudget $repository): void {
    $this->service = new BudgetFinder($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {      
    
    try {
      $serviceRequest = new BudgetFinderRequest();
      $serviceRequest->budgetId = $this->params->budgetid;
      $budget = $this->service->invoke($serviceRequest);

      return new JsonResponse([
        'success' => [
          'budget_id' => $budget->budgetId,
          'owner_id' => $budget->ownerId,
          'budget_name' => $budget->budgetName,
          'budget_status' => $budget->budgetStatus,
          'income'=>[
            'amount' => $budget->amount,
            'type' => $budget->type
          ],
          'month_max' => $budget->max,
          'month_total'=> $budget->total,
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