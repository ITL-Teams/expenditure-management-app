<?php
namespace App\Infraestructure\Controller\CreateSignature;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\CreateSignature\SignatureCreator;
use App\Application\CreateSignature\SignatureCreatorRequest;
use App\Domain\ISignatureRepository;

class SignatureCreatorControllerResponse extends ControllerResponse {  
  private SignatureCreator $service;

  public function init(ISignatureRepository $repository): void {
    $this->service = new SignatureCreator($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {      
    $payload = $this->getPayload($request);

    try {
      $this->validatePayload($payload);

      $serviceRequest = new SignatureCreatorRequest();
      // values
      $Signature = $this->service->invoke($serviceRequest);

      return new JsonResponse([
        'success' => [
          'message' => 'Signature has been created',
          'id' => $Signature->getId()->toString()
        ]
      ]);

    } catch(RequestException | Exception $exeption) {
      return new JsonResponse([
        'error' => [
          'message' => 'Signature was not created',
          'reason' => $exeption->getMessage()
        ]
      ]);
    }
  }

  public function validatePayload(object $payload): void {    
    $this->validatePayloadBody([
      // values
    ]);    
  }
}
