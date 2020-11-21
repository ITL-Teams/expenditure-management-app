<?php
namespace App\Infraestructure\Controller\EnterpriseAccountFinder;

use Rareloop\Router\RouteParams;
use App\Infraestructure\Controller\Controller;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Database\AccountMySqlRepository;

class EnterpriseAccountFinderController implements Controller {

  public function handler(RouteParams $params): ControllerResponse {
    $response = new EnterpriseAccountFinderControllerResponse($params);
    $response->init(new AccountMySqlRepository());
    return $response;
  }

}
