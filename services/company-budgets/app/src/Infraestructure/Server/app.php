<?php

use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response\EmptyResponse;
use App\Infraestructure\Server\ApiRoutes;

$url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
$request = new ServerRequest([], [], $url, $_SERVER['REQUEST_METHOD'], 'php://input');

$router = ApiRoutes::getRouter();

$response = $router->match($request);

if($response->getStatusCode() != 200)
  $response = new EmptyResponse($response->getStatusCode());

http_response_code($response->getStatusCode());
if (isset($response->getHeaders()['content-type']))
  header("Content-Type: ".$response->getHeaders()['content-type'][0]);

echo $response->getBody()->getContents();
