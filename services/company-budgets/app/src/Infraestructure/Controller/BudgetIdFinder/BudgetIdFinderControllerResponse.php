<?php
namespace App\Infraestructure\Controller\BudgetIdFinder;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\BudgetIdFinder\BudgetIdFinders;
use App\Application\BudgetIdFinder\BudgetIdFinderRequest;
use App\Domain\IBudgetRepository;

class BudgetIdFinderControllerResponse extends ControllerResponse {  
  private BudgetIdFinders $service;

  public function init(IBudgetRepository $repository): void {
    $this->service = new BudgetIdFinders($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {      
    
    try {
      $serviceRequest = new BudgetIdFinderRequest();
      $serviceRequest->ownerId = $this->params->ownerid;
      $budget = $this->service->invoke($serviceRequest);

      return new JsonResponse([
        'success' => [
          'owner_id' => $budget->ownerId,
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
