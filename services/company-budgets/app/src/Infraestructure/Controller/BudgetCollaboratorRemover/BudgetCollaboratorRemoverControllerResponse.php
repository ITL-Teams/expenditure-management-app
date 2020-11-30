<?php
namespace App\Infraestructure\Controller\BudgetCollaboratorRemover;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\BudgetCollaboratorRemover\BudgetCollaboratorRemover;
use App\Application\BudgetCollaboratorRemover\BudgetCollaboratorRemoverRequest;
use App\Domain\IBudgetRepository;

class BudgetCollaboratorRemoverControllerResponse extends ControllerResponse {  
  private BudgetCollaboratorRemover $service;

  public function init(IBudgetRepository $repository): void {
    $this->service = new BudgetCollaboratorRemover($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {      
    try {
      $serviceRequest = new BudgetCollaboratorRemoverRequest();
      $serviceRequest->collaboratorId = $this->params->collaboratorid;
      $serviceRequest->budgetId = $this->params->budgetid;
      $budget = $this->service->invoke($serviceRequest);

      return new JsonResponse([
        'success' => [
          'message' => 'Collaborator: '
            .$this->params->collaboratorid.' '
            .' has been removed to the budget',
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
}
