<?php
namespace App\Infraestructure\Controller\BudgetItemDeleter;

use Rareloop\Router\RouteParams;
use App\Infraestructure\Controller\Controller;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Database\MySqlBudgetRepository;
use App\Domain\IPersonalBudget;

class BudgetItemDeleterController implements Controller {
  private IPersonalBudget $repository;

  public function handler(RouteParams $params): ControllerResponse {
    $response = new BudgetItemDeleterControllerResponse($params);
    $response->init(new MySqlBudgetRepository());
    return $response;
  }
}