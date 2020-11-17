<?php
namespace App\Infraestructure\Controller;

use Rareloop\Router\RouteParams;
use Rareloop\Router\Responsable;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Infraestructure\Controller\Exception\RequestException;

abstract class ControllerResponse implements Responsable {
  protected RouteParams $params;

  public function __construct(RouteParams $params) {
    $this->params = $params;
  }

  abstract public function toResponse(RequestInterface $request) : ResponseInterface;

  public function getPayload(RequestInterface $request) {
    return json_decode($request->getBody()->getContents());
  }

  /**
   * @param array $params
   * $params = array([
   *  "value_name" => string,
   *  "value" => any,
   *  "expected" => string = "boolean", "integer", "double", "string", "array", "object", "resource", "NULL", "unknown type"
   * ])
   *
   */
  protected function validatePayloadBody(array $params): void {
    foreach($params as $param) {
      $value_type = gettype($param['value']);

      if($value_type != $param['expected'])
        throw new RequestException(
          $param['value_name'] . ' must be ' . $param['expected']
          . ', '. $value_type . ' received instead'
        );
    }
  }
}
