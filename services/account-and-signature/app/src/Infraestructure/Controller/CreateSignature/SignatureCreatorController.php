<?php
namespace App\Infraestructure\Controller\CreateSignature;

use App\Application\CreateSignature\SignatureCreatorRequest;
use App\Domain\Entity\Account;
use App\Domain\Entity\Signature;
use Rareloop\Router\RouteParams;
use App\Infraestructure\Controller\Controller;
use App\Infraestructure\Controller\ControllerResponse;
class SignatureCreatorController implements Controller {

  public function handler(RouteParams $params): ControllerResponse {
    $response = new SignatureCreatorControllerResponse($params);
    $response->init();
    return $response;
  }
}
