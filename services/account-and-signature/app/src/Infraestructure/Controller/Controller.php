<?php
namespace App\Infraestructure\Controller;

use Rareloop\Router\RouteParams;

interface Controller {
  public function handler(RouteParams $params): ControllerResponse;
}
