<?php
namespace App\Infraestructure\Controller\FindUser;

use Rareloop\Router\RouteParams;
use App\Infraestructure\Controller\Controller;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Database\MySqlUserRepository;
use App\Domain\IUserRepository;

class UserFinderController implements Controller {
  private IUserRepository $repository;

  public function handler(RouteParams $params): ControllerResponse {
    $response = new UserFinderControllerResponse($params);
    $response->init(new MySqlUserRepository());
    return $response;
  }

}
