<?php
namespace App\Infraestructure\Controller\BudgetItemCreator;

use Rareloop\Router\RouteParams;
use App\Infraestructure\Controller\Controller;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Database\MySqlBudgetRepository;
use App\Domain\IPersonalBudget;

class BudgetItemCreatorController implements Controller {
  private IPersonalBudget $repository;

  public function handler(RouteParams $params): ControllerResponse {
    $response = new BudgetItemCreatorControllerResponse($params);
    $response->init(new MySqlBudgetRepository());
    return $response;
  }
}