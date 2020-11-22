<?php

namespace App\Infraestructure\Controller\CreateSignature;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\CreateSignature\SignatureCreator;

class SignatureCreatorControllerResponse extends ControllerResponse
{
  private SignatureCreator $service;

  public function init(): void
  {
    $this->service = new SignatureCreator();
  }

  public function toResponse(RequestInterface $reques): ResponseInterface
  {

    try {
      $Signature = $this->service->invoke();

      return new JsonResponse([
        'success' => [
          'message' => 'Signature has been created',
          'id' => $Signature->signature->toString()
        ]
      ]);
    } catch (RequestException | Exception $exeption) {
      return new JsonResponse([
        'error' => [
          'message' => 'Signature was not created',
          'reason' => $exeption->getMessage()
        ]
      ]);
    }
  }
}
