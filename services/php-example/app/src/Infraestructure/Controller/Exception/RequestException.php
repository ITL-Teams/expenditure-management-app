<?php
namespace App\Infraestructure\Controller\Exception;

class RequestException extends \Exception {
  public function __construct($message = null) {
    parent::__construct('RequestException: ' . $message);
  }
}
