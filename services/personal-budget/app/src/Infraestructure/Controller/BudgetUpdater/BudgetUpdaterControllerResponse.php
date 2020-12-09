<?php
namespace App\Infraestructure\Controller\BudgetUpdater;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\BudgetUpdater\BudgetUpdater;
use App\Application\BudgetUpdater\BudgetUpdaterRequest;
use App\Domain\IPersonalBudget;

class BudgetUpdaterControllerResponse extends ControllerResponse {  
  private BudgetUpdater $service;

  public function init(IPersonalBudget $repository): void {
    $this->service = new BudgetUpdater($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {      
    $payload = $this->getPayload($request);

    try {
      $this->validatePayload($payload);

      $serviceRequest = new BudgetUpdaterRequest();     
      $serviceRequest->budgetId = $this->params->budgetid; 
      $serviceRequest->budgetName = $payload->budget_name;
      $serviceRequest->amount = $payload->income->amount;
      $serviceRequest->type = $payload->income->type;
      
      $budget = $this->service->invoke($serviceRequest);

      return new JsonResponse([
        'success' => [
          'message' => 'Budget:'.$this->params->budgetid.
            ' income: { amount:'.$payload->income->amount.
              ' type:'.$payload->income->type.
              ' }'
            .' has been updated in db'
        ]
      ]);

    } catch(RequestException | Exception $exeption) {
      return new JsonResponse([
        'error' => [
          'message' => 'Personal budget was not updated',
          'reason' => $exeption->getMessage()
        ]
      ]);
    }
  }

  public function validatePayload(object $payload): void {    
    $this->validatePayloadBody([
     [
        "value_name" => 'budget_name',
        "value" => $payload->budget_name,
        "expected" => "string"
      ],
      [
        "value_name" => 'amount',
        "value" => $payload->income->amount,
        "expected" => "integer"
      ],
      [
        "value_name" => 'type',
        "value" => $payload->income->type,
        "expected" => "string"
      ]
    ]);    
  }
}
