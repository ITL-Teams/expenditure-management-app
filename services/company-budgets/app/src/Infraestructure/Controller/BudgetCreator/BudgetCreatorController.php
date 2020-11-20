<?php
namespace App\Infraestructure\Controller\BudgetCreator;

use Rareloop\Router\RouteParams;
use App\Infraestructure\Controller\Controller;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Database\MySqlUserRepository;
use App\Domain\IBudgetRepository;

class BudgetCreatorController implements Controller {
  private ICompanyBudgetRepository $repository;

  public function handler(RouteParams $params): ControllerResponse {
    $response = new BudgetCreatorControllerResponse($params);
    $response->init(new MySqlUserRepository());
    return $response;
  }

}
