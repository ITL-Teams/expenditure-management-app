<?php
namespace App\Infraestructure\Controller\BudgetCollaboratorAdder;

use Rareloop\Router\RouteParams;
use App\Infraestructure\Controller\Controller;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Database\MySqlBudgetRepository;
use App\Domain\IBudgetRepository;

class BudgetCollaboratorController implements Controller {
  private IBudgetRepository $repository;

  public function handler(RouteParams $params): ControllerResponse {
    $response = new BudgetCollaboratorControllerResponse($params);
    $response->init(new MySqlBudgetRepository());
    return $response;
  }

}
