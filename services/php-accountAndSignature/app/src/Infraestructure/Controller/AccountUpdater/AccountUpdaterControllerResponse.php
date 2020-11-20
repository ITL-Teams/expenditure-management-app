<?php
namespace App\Infraestructure\Controller\AccountUpdater;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\AccountUpdater\AccountUpdater;
use App\Application\AccountUpdater\AccountUpdaterRequest;
use App\Domain\IAccountRepository;

class AccountUpdaterControllerResponse extends ControllerResponse {  
  private AccountUpdater $service;

  public function init(IAccountRepository $repository): void {
    $this->service = new AccountUpdater($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {      
    $payload = $this->getPayload($request);

    try {
      $this->validatePayload($payload);

      $serviceRequest = new AccountUpdaterRequest();
      $serviceRequest->accountId = $this->params->account_id;
      $serviceRequest->email = $payload->email;
      $serviceRequest->firstName = $payload->firstName;
      $serviceRequest->lastName = $payload->lastName;
      $serviceRequest->passworod = $payload->password;
      $serviceRequest->signature = $payload->signature;
      $account = $this->service->invoke($serviceRequest);
      $response = [
          'account_id' => $account->accountId,
          'email' => $payload->email,
          'firstName' => $payload->firstName,
          'lastName' => $payload->lastName
      ];

      if($payload->signature!=null)
        $response['signature'] = $payload->signature;

      return new JsonResponse(['success' => $response]);

    } catch(RequestException | Exception $exeption) {
      return new JsonResponse([
        'error' => [
          'message' => 'Account was not updated',
          'reason' => $exeption->getMessage()
        ]
      ]);
    }
  }

  public function validatePayload(object $payload): void {    
    $this->validatePayloadBody([
      [
        "value_name" => 'accountId',
        "value" => $payload->accountId,
        "expected" => "string"
      ],
      [
        "value_name" => 'email',
        "value" => $payload->email,
        "expected" => "string"
      ],
      [
        "value_name" => 'firstName',
        "value" => $payload->firstName,
        "expected" => "string"
      ],
      [
        "value_name" => 'lastName',
        "value" => $payload->lastName,
        "expected" => "string"
      ]
    ]);    
  }
}
