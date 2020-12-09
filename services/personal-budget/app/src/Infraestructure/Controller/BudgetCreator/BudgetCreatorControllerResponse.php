<?php
namespace App\Infraestructure\Controller\BudgetCreator;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\BudgetCreator\BudgetCreator;
use App\Application\BudgetCreator\BudgetCreatorRequest;
use App\Domain\IPersonalBudget;

class BudgetCreatorControllerResponse extends ControllerResponse {  
  private BudgetCreator $service;

  public function init(IPersonalBudget $repository): void {
    $this->service = new BudgetCreator($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {      
    $payload = $this->getPayload($request);

    try {
      $this->validatePayload($payload);

      $serviceRequest = new BudgetCreatorRequest();
      $serviceRequest->budgetId = $this->params->budgetid;
      $serviceRequest->budgetName = $payload->budget_name;
      $serviceRequest->ownerId = $payload->owner_id;
      $serviceRequest->amount = $payload->income->amount;
      $serviceRequest->type = $payload->income->type;
      $budget = $this->service->invoke($serviceRequest);

      return new JsonResponse([
        'success' => [
          'message' => 'Budget: '
            .$payload->budget_name.' '
            .$payload->owner_id.' '
            .$payload->amount.' '
            .$payload->type.' '
            .' has been registered in db',
          'id' => $budget->getId()->toString()
        ]
      ]);

    } catch(RequestException | Exception $exeption) {
      return new JsonResponse([
        'error' => [
          'message' => 'Personal budget was not registered',
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
        "value_name" => 'owner_id',
        "value" => $payload->owner_id,
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
