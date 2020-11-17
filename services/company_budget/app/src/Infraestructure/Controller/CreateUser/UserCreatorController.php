<?php
namespace App\Infraestructure\Controller\CreateUser;

use Rareloop\Router\RouteParams;
use App\Infraestructure\Controller\Controller;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Database\MySqlUserRepository;
use App\Domain\IUserRepository;

class UserCreatorController implements Controller {
  private IUserRepository $repository;

  public function handler(RouteParams $params): ControllerResponse {
    $response = new UserCreatorControllerResponse($params);
    $response->init(new MySqlUserRepository());
    return $response;
  }

}
