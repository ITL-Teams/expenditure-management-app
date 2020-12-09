<?php
namespace App\Infraestructure\Controller\BudgetMaster;

use Rareloop\Router\RouteParams;
use App\Infraestructure\Controller\Controller;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Database\MySqlBudgetRepository;
use App\Domain\IBudgetRepository;

class BudgetMasterController implements Controller {
  private IBudgetRepository $repository;

  public function handler(RouteParams $params): ControllerResponse {
    $response = new BudgetMasterControllerResponse($params);
    $response->init(new MySqlBudgetRepository());
    return $response;
  }

}
