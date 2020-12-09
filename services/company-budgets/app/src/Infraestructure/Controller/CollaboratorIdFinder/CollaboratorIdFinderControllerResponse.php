<?php
namespace App\Infraestructure\Controller\CollaboratorIdFinder;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\CollaboratorIdFinder\CollaboratorIdFinders;
use App\Application\CollaboratorIdFinder\CollaboratorIdFinderRequest;
use App\Domain\IBudgetRepository;

class CollaboratorIdFinderControllerResponse extends ControllerResponse {  
  private CollaboratorIdFinders $service;

  public function init(IBudgetRepository $repository): void {
    $this->service = new CollaboratorIdFinders($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {      
    
    try {
      $serviceRequest = new CollaboratorIdFinderRequest();
      $serviceRequest->collaboratorId = $this->params->collaboratorid;
      $budget = $this->service->invoke($serviceRequest);

      return new JsonResponse([
        'success' => [
          'collaborator_id' => $budget->collaboratorId,
          'budgets' => $budget->ownerBudegts
        ]
      ]);

    } catch(RequestException | Exception $exeption) {
      return new JsonResponse([
        'error' => [
          'message' => 'Budgets not found',
          'reason' => $exeption->getMessage()
        ]
      ]);
    }
  }
}
