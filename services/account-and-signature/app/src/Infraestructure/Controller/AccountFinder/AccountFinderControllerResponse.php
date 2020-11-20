<?php

namespace App\Infraestructure\Controller\AccountFinder;

use \Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Infraestructure\Controller\ControllerResponse;
use App\Infraestructure\Controller\Exception\RequestException;
use App\Application\AccountFinder\AccountFinder;
use App\Application\AccountFinder\AccountFinderRequest;
use App\Domain\IAccountRepository;

class AccountFinderControllerResponse extends ControllerResponse
{
  private AccountFinder $service;

  public function init(IAccountRepository $repository): void
  {
    $this->service = new AccountFinder($repository);
  }

  public function toResponse(RequestInterface $request): ResponseInterface
  {
    try{
      $serviceRequest = new AccountFinderRequest();
      $serviceRequest->accountId = $this->params->accountid;
      $account = $this->service->invoke($serviceRequest);
      $response = [
        'account_id' => $account->accountId,
        'email' => $account->email,
        'firstName' => $account->firstName,
        'lastName' => $account->lastName,
        'signature' => $account->signature,
        'enterprise_account' => $account->enterpriseAccount
      ];

      if ($account->signature != null)
        $response['signature'] = $account->signature;
        
      if ($account->signature != null)
        $response['enterpriseAccount'] = $account->enterpriseAccount;

      return new JsonResponse(['success' => $response]);
    } catch (RequestException | Exception $exeption) {
      return new JsonResponse([
        'error' => [
          'message' => 'Account not found',
          'reason' => $exeption->getMessage()
        ]
      ]);
    }
  }
}
