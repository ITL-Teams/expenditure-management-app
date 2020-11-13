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
ApiRoutes::addRoute(['GET'], '/{id}', 'App\Infraestructure\Controller\Test\TestController@handler');
