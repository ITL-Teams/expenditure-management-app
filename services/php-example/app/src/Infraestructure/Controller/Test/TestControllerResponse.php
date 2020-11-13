<?php
namespace App\Infraestructure\Controller\Test;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;

class TestControllerResponse extends ControllerResponse {
  public function toResponse(RequestInterface $request): ResponseInterface
  {      
    $payload = $this->getPayload($request);
    try {
      $this->validatePayloadBody([
        [
          "value_name" => 'name',
          "value" => $payload->name,
          "expected" => "string"
        ]
      ]);

      return new JsonResponse([
        "id" => $this->params->id,
        "name" => $payload->name
      ]);

    } catch(RequestException $exeption) {
      return new JsonResponse([
        "message" => 'Failed Test',
        "reason" => $exeption->getMessage()
      ]);
    }
  }
}
