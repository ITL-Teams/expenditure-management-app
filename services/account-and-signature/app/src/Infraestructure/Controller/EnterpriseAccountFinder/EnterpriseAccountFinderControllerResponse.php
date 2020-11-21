<?php

namespace App\Infraestructure\Controller\EnterpriseAccountFinder;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\EnterpriseAccountFinder\EnterpriseAccountFinder;
use App\Application\EnterpriseAccountFinder\EnterpriseAccountFinderRequest;
use App\Domain\IAccountRepository;

class EnterpriseAccountFinderControllerResponse extends ControllerResponse
{
  private EnterpriseAccountFinder $service;

  public function init(IAccountRepository $repository): void
  {
    $this->service = new EnterpriseAccountFinder($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {    
    try {      
      $serviceRequest = new EnterpriseAccountFinderRequest;      
      $accounts = $this->service->invoke($serviceRequest);            

      return new JsonResponse([
        'success' => $accounts
      ]);
    } catch (RequestException | Exception $exeption) {
      return new JsonResponse([
        'error' => [
          'message' => 'Account was not updated',
          'reason' => $exeption->getMessage()
        ]
      ]);
    }
  }

}
