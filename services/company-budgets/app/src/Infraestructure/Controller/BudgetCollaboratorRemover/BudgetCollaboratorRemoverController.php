<?php
namespace App\Infraestructure\Controller\BudgetCollaboratorRemover;

use Rareloop\Router\RouteParams;
use App\Infraestructure\Controller\Controller;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Database\MySqlBudgetRepository;
use App\Domain\IBudgetRepository;

class BudgetCollaboratorRemoverController implements Controller {
  private IBudgetRepository $repository;

  public function handler(RouteParams $params): ControllerResponse {
    $response = new BudgetCollaboratorRemoverControllerResponse($params);
    $response->init(new MySqlBudgetRepository());
    return $response;
  }

}
