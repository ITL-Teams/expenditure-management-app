<?php 
namespace App\Infraestructure\Server;

use Rareloop\Router\Router;

class ApiRoutes {
  static private Router $router;

  public static function init(): void {
    static::$router = new Router;
  }

  public static function addRoute(array $methods, string $url, string $controller): void {
    static::$router->map($methods, $url, $controller);
  }

  public static function getRouter(): Router {
    return static::$router;
  }
}

ApiRoutes::init();
ApiRoutes::addRoute(['GET'], '/signature/create', 'App\Infraestructure\Controller\CreateSignature\SignatureCreatorController@handler');
ApiRoutes::addRoute(['PUT'], '/update/{accountid}', 'App\Infraestructure\Controller\AccountUpdater\AccountUpdaterController@handler');
ApiRoutes::addRoute(['GET'], '/find/pending-review', 'App\Infraestructure\Controller\EnterpriseAccountFinder\EnterpriseAccountFinderController@handler');
ApiRoutes::addRoute(['GET'], '/find/{accountid}', 'App\Infraestructure\Controller\AccountFinder\AccountFinderController@handler');
ApiRoutes::addRoute(['PUT'], '/verify/{accountid}', 'App\Infraestructure\Controller\EnterpriseAccountVerifier\EnterpriseAccountVerifierController@handler');