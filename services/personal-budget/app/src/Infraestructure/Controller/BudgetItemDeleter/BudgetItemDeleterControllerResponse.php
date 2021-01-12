<?php
namespace App\Infraestructure\Controller\BudgetItemDeleter;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\BudgetItemDeleter\BudgetItemDeleter;
use App\Application\BudgetItemDeleter\BudgetItemDeleterRequest;
use App\Domain\IPersonalBudget;

class BudgetItemDeleterControllerResponse extends ControllerResponse {  
  private BudgetItemDeleter $service;

  public function init(IPersonalBudget $repository): void {
    $this->service = new BudgetItemDeleter($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {      
    try {
      $serviceRequest = new BudgetItemDeleterRequest();
      $serviceRequest->chargeId = $this->params->chargeid;
      $charge = $this->service->invoke($serviceRequest);

      return new JsonResponse([
        'success' => [
          'message' => "The charge was properly removed ".$this->params->chargeid
        ]
      ]);

    } catch(RequestException | Exception $exeption) {
      return new JsonResponse([
        'error' => [
          'message' => 'The charge was not eliminated',
          'reason' => $exeption->getMessage()
        ]
      ]);
    }
  }
}