<?php
namespace App\Infraestructure\Database;

class MySqlRepository {  
  private static $connection = null;

  private function getCredentials(): array {
    $DB_HOST = isset($_ENV['DB_HOST']) ?
      $_ENV['DB_HOST'] : $_ENV['DEV_DB_HOST'];

    $DB_NAME = isset($_ENV['DB_DATABASE']) ?
      $_ENV['DB_DATABASE'] : $_ENV['DEV_DB_DATABASE'];

    $DB_USER = isset($_ENV['DB_USER']) ?
      $_ENV['DB_USER'] : $_ENV['DEV_DB_USER'];

    $DB_PASSWORD = isset($_ENV['DB_PASSWORD']) ?
      $_ENV['DB_PASSWORD'] : $_ENV['DEV_DB_PASSWORD'];

    return [
      "DB_HOST" => $DB_HOST,
      "DB_NAME" => $DB_NAME,
      "DB_USER" => $DB_USER,
      "DB_PASSWORD" => $DB_PASSWORD
    ];
  }

  protected function getConnection(): \PDO {
    if(static::$connection != null)
      return $connection;    

    $CREDENTIALS = $this->getCredentials();

    try {
      static::$connection = new \PDO(
        "mysql:host=".$CREDENTIALS['DB_HOST'].
        ";dbname=".$CREDENTIALS['DB_NAME'],
        $CREDENTIALS['DB_USER'],
        $CREDENTIALS['DB_PASSWORD']
      );
    } catch (\PDOException $exception) {
      throw new \Exception("Exception: " . $exception->getMessage());
    }

    return static::$connection;
  }
}
