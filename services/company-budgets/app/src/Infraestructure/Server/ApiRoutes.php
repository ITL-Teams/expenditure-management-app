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
ApiRoutes::addRoute(['POST'], '/create', 'App\Infraestructure\Controller\BudgetCreator\BudgetCreatorController@handler');
ApiRoutes::addRoute(['PUT'], '/update/{budgetid}', 'App\Infraestructure\Controller\BudgetUpdater\BudgetUpdaterController@handler');
ApiRoutes::addRoute(['DELETE'], '/delete/{budgetid}', 'App\Infraestructure\Controller\BudgetDeleter\BudgetDeleterController@handler');
//ApiRoutes::addRoute(['GET'], '/get/{userId}', 'App\Infraestructure\Controller\FindUser\UserFinderController@handler');
