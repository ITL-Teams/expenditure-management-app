<?php
namespace App\Infraestructure\Controller\BudgetDeleter;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\BudgetUpdater\BudgetDeleter;
use App\Application\BudgetCreator\BudgetDeleterRequest;
use App\Domain\IBudgetRepository;

class BudgetDeleterControllerResponse extends ControllerResponse {  
  private BudgetDeleter $service;

  public function init(IBudgetRepository $repository): void {
    $this->service = new BudgetDeleter($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {      
    $payload = $this->getPayload($request);

    try {
      $this->validatePayload($payload);

      $serviceRequest = new BudgetDeleterRequest();
      $serviceRequest->budgetId = $payload->budget_id;
      $budget = $this->service->invoke($serviceRequest);

      return new JsonResponse([
        'success' => [
          'message' => 'Budget: '
            .$payload->budget_id.' '
            .' has been deleted in db'
        ]
      ]);

    } catch(RequestException | Exception $exeption) {
      return new JsonResponse([
        'error' => [
          'message' => 'Company budget was not deleted',
          'reason' => $exeption->getMessage()
        ]
      ]);
    }
  }

  public function validatePayload(object $payload): void {    
    $this->validatePayloadBody([
      [
        "value_name" => 'budget_id',
        "value" => $payload->budget_id,
        "expected" => "string"
      ]
    ]);    
  }
}
