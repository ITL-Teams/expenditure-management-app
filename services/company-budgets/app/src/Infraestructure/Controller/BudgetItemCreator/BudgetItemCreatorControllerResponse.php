<?php
namespace App\Infraestructure\Controller\BudgetItemCreator;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\Charge\BudgetItemCreator;
use App\Application\Charge\BudgetItemCreatorRequest;
use App\Domain\IBudgetRepository;

class BudgetItemCreatorControllerResponse extends ControllerResponse {  
  private BudgetItemCreator $service;

  public function init(IBudgetRepository $repository): void {
    $this->service = new BudgetItemCreator($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {      
    $payload = $this->getPayload($request);

    try {
      $serviceRequest = new BudgetItemCreatorRequest();
      $serviceRequest->collaboratorId = $payload->collaborator_id;
      $serviceRequest->budgetId = $this->params->budgetid;
      $serviceRequest->title = $payload->title;
      $serviceRequest->budgetLimit = $payload->amount;
      $charge = $this->service->invoke($serviceRequest);

      return new JsonResponse([
        'success' => [
          'collaborator_id' => $payload->collaborator_id,
          'charge_id' => $charge->getId()->toString(),
          'date' => $charge->getDate()->toString(),
          'time' => $charge->getTime()->toString()
        ]
      ]);

    } catch(RequestException | Exception $exeption) {
      return new JsonResponse([
        'error' => [
          'message' => 'Charge was not registered',
          'reason' => $exeption->getMessage()
        ]
      ]);
    }
  }
}
