<?php
namespace App\Infraestructure\Controller\CreateUser;

use Rareloop\Router\RouteParams;
use App\Infraestructure\Controller\Controller;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Database\MySqlUserRepository;
use App\Domain\ISignatureRepository;

class SignatureCreatorController implements Controller {
  private ISignatureRepository $repository;

  public function handler(RouteParams $params): ControllerResponse {
    $response = new SignatureCreatorControllerResponse($params);
    $response->init(new MySqlUserRepository());
    return $response;
  }

}
