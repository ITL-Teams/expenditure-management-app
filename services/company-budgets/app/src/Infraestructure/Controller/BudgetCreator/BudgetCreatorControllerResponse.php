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
use App\Domain\IBudgetRepository;

class BudgetCreatorControllerResponse extends ControllerResponse {  
  private BudgetCreator $service;

  public function init(IBudgetRepository $repository): void {
    $this->service = new BudgetCreator($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {      
    $payload = $this->getPayload($request);

    try {
      $this->validatePayload($payload);

      $serviceRequest = new BudgetCreatorRequest();
      $serviceRequest->budgetName = $payload->budget_name;
      $serviceRequest->ownerId = $payload->owner_id;
      $serviceRequest->budgetLimit = $payload->budget_limit;
      $budget = $this->service->invoke($serviceRequest);

      return new JsonResponse([
        'success' => [
          'message' => 'Budget: '
            .$payload->budget_name.' '
            .$payload->owner_id.' '
            .$payload->budget_limit.' '
            .' has been registered in db',
          'id' => $budget->getId()->toString()
        ]
      ]);

    } catch(RequestException | Exception $exeption) {
      return new JsonResponse([
        'error' => [
          'message' => 'Company budget was not registered',
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
        "value_name" => 'budget_limit',
        "value" => $payload->budget_limit,
        "expected" => "integer"
      ]
    ]);    
  }
}
