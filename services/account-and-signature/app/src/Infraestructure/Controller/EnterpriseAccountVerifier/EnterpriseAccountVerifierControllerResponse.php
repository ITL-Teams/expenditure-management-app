<?php

namespace App\Infraestructure\Controller\EnterpriseAccountVerifier;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\EnterpriseAccountVerifier\EnterpriseAccountVerifier;
use App\Application\EnterpriseAccountVerifier\EnterpriseAccountVerifierRequest;
use App\Domain\IAccountRepository;

class EnterpriseAccountVerifierControllerResponse extends ControllerResponse
{
  private EnterpriseAccountVerifier $service;

  public function init(IAccountRepository $repository): void
  {
    $this->service = new EnterpriseAccountVerifier($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {
    $payload = $this->getPayload($request);

    try {
      $this->validatePayload($payload);

      $serviceRequest = new EnterpriseAccountVerifierRequest;
      $serviceRequest->account_id = $this->params->accountid;
      $serviceRequest->verify = $payload->verify;
      
      $serviceResponse = $this->service->invoke($serviceRequest);

      return new JsonResponse([
        'success' => $serviceResponse->message
      ]);
    } catch (RequestException | Exception $exeption) {
      return new JsonResponse([
        'error' => [
          'message' => 'Account was not verified',
          'reason' => $exeption->getMessage()
        ]
      ]);
    }
  }

  public function validatePayload(object $payload): void {    
    $this->validatePayloadBody([
      [
        "value_name" => 'verify',
        "value" => $payload->verify,
        "expected" => "boolean"
      ]
    ]);
  }

}
