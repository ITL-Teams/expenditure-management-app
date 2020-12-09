<?php
namespace App\Infraestructure\Controller\BudgetItemRemover;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\BudgetItemRemover\BudgetItemRemover;
use App\Application\BudgetItemRemover\BudgetItemRemoverRequest;
use App\Domain\IBudgetRepository;

class BudgetItemRemoverControllerResponse extends ControllerResponse {  
  private BudgetItemRemover $service;

  public function init(IBudgetRepository $repository): void {
    $this->service = new BudgetItemRemover($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {      
    try {
      $serviceRequest = new BudgetItemRemoverRequest();
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
