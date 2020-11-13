<?php

namespace App\Infraestructure\Controller\Test;

use Rareloop\Router\RouteParams;
use App\Infraestructure\Controller\Controller;
use App\Infraestructure\Controller\ControllerResponse;

class TestController implements Controller {
  public function handler(RouteParams $params): ControllerResponse {
    $response = new TestControllerResponse($params);
    return $response;
  }
}
