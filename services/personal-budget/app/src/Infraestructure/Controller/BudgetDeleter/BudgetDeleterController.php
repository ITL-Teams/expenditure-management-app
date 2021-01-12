<?php
namespace App\Infraestructure\Controller\BudgetDeleter;

use Rareloop\Router\RouteParams;
use App\Infraestructure\Controller\Controller;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Database\MySqlBudgetRepository;
use App\Domain\IPersonalBudget;

class BudgetDeleterController implements Controller {
  private IPersonalBudget $repository;

  public function handler(RouteParams $params): ControllerResponse {
    $response = new BudgetDeleterControllerResponse($params);
    $response->init(new MySqlBudgetRepository());
    return $response;
  }

}
