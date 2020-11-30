<?php
namespace App\Infraestructure\Controller\BudgetCollaboratorAdder;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\BudgetCollaboratorAdder\BudgetCollaboratorAdder;
use App\Application\BudgetCollaboratorAdder\BudgetCollaboratorAdderRequest;
use App\Domain\IBudgetRepository;

class BudgetCollaboratorControllerResponse extends ControllerResponse {  
  private BudgetCollaboratorAdder $service;

  public function init(IBudgetRepository $repository): void {
    $this->service = new BudgetCollaboratorAdder($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {      
    $payload = $this->getPayload($request);

    try {
      $this->validatePayload($payload);

      $serviceRequest = new BudgetCollaboratorAdderRequest();
      $serviceRequest->collaboratorId = $payload->collaborator_id;
      $serviceRequest->budgetId = $this->params->budgetid;
      $serviceRequest->collaboratorName = $payload->collaborator_name;
      $serviceRequest->budgetPercentage = $payload->budget_percentage;
      $budget = $this->service->invoke($serviceRequest);

      return new JsonResponse([
        'success' => [
          'message' => 'Collaborator: '
            .$payload->collaborator_name.' '
            .' has been added to the budget',
          'id' => $this->params->budgetid
        ]
      ]);

    } catch(RequestException | Exception $exeption) {
      return new JsonResponse([
        'error' => [
          'message' => 'Collaborator was not registered',
          'reason' => $exeption->getMessage()
        ]
      ]);
    }
  }

  public function validatePayload(object $payload): void {    
    $this->validatePayloadBody([
      [
        "value_name" => 'collaborator_id',
        "value" => $payload->collaborator_id,
        "expected" => "string"
      ],
      [
        "value_name" => 'collaborator_name',
        "value" => $payload->collaborator_name,
        "expected" => "string"
      ],
      [
        "value_name" => 'budget_percentage',
        "value" => $payload->budget_percentage,
        "expected" => "integer"
      ]
    ]);    
  }
}
