<?php
namespace App\Infraestructure\Controller\BudgetDeleter;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\BudgetDeleter\BudgetDeleter;
use App\Application\BudgetDeleter\BudgetDeleterRequest;
use App\Domain\IBudgetRepository;

class BudgetDeleterControllerResponse extends ControllerResponse {  
  private BudgetDeleter $service;

  public function init(IBudgetRepository $repository): void {
    $this->service = new BudgetDeleter($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {      

    try {

      $serviceRequest = new BudgetDeleterRequest();
      $serviceRequest->budgetId = $this->params->budgetid;
      $budget = $this->service->invoke($serviceRequest);

      return new JsonResponse([
        'success' => [
          'message' => 'Budget: '
            .$this->params->budget_id.' '
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
}
