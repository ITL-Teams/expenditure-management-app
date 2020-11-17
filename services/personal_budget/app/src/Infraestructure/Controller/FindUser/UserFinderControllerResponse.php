<?php
namespace App\Infraestructure\Controller\FindUser;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\GetUser\UserFinder;
use App\Application\GetUser\UserFinderRequest;
use App\Domain\IUserRepository;

class UserFinderControllerResponse extends ControllerResponse {  
  private UserFinder $service;

  public function init(IUserRepository $repository): void {
    $this->service = new UserFinder($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {
    try {
      $serviceRequest = new UserFinderRequest();
      $serviceRequest->user_id = $this->params->userId;
      $user = $this->service->invoke($serviceRequest);

      return new JsonResponse([
        'success' => [
          'user' => [
            'id' => $user->getId()->toString(),
            'name' => $user->getName()->toString()
          ]
        ]
      ]);

    } catch(RequestException | Exception $exeption) {
      return new JsonResponse([
        'error' => [
          'message' => 'User not found',
          'reason' => $exeption->getMessage()
        ]
      ]);
    }
  }
}
