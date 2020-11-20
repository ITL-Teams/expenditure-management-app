<?php
namespace App\Infraestructure\Controller\CreateUser;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\CreateUser\UserCreator;
use App\Application\CreateUser\UserCreatorRequest;
use App\Domain\IUserRepository;

class BudgetCreatorControllerResponse extends ControllerResponse {  
  private BudgetCreator $service;

  public function init(IBudgetRepository $repository): void {
    $this->service = new Budget($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {      
    $payload = $this->getPayload($request);

    try {
      $this->validatePayload($payload);

      $serviceRequest = new UserCreatorRequest();
      $serviceRequest->firstName = $payload->firstName;
      $serviceRequest->lastName = $payload->lastName;
      $user = $this->service->invoke($serviceRequest);

      return new JsonResponse([
        'success' => [
          'message' => 'User: '
            .$payload->firstName.' '
            .$payload->lastName.' '
            .' has been registered in db',
          'id' => $user->getId()->toString()
        ]
      ]);

    } catch(RequestException | Exception $exeption) {
      return new JsonResponse([
        'error' => [
          'message' => 'User was not registered',
          'reason' => $exeption->getMessage()
        ]
      ]);
    }
  }

  public function validatePayload(object $payload): void {    
    $this->validatePayloadBody([
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
