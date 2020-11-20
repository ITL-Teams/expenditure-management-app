<?php
namespace App\Infraestructure\Controller\AccountFinder;

use Rareloop\Router\RouteParams;
use App\Infraestructure\Controller\Controller;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Database\AccountMySqlRepository;

class AccountFinderController implements Controller {

  public function handler(RouteParams $params): ControllerResponse {
    $response = new AccountFinderControllerResponse($params);
    $response->init(new AccountMySqlRepository());
    return $response;
  }

}
