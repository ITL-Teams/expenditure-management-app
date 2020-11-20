<?php
namespace App\Infraestructure\Controller\AccountUpdater;

use Rareloop\Router\RouteParams;
use App\Infraestructure\Controller\Controller;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Database\AccountMySqlRepository;

class AccountUpdaterController implements Controller {

  public function handler(RouteParams $params): ControllerResponse {
    $response = new AccountUpdaterControllerResponse($params);
    $response->init(new AccountMySqlRepository());
    return $response;
  }

}
