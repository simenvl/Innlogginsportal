<?php
namespace classes;

use PDO;
use PDOException;

class DatabaseConnection
{
  private static $instance;
  private $connection, // database connection
    $error = false,
    $error_msg;

  // connection info
  private $host = 'localhost',
    $db_name = 'datasikkerhet_gruppe14',
    $db_password = 'Gruppe-14',
    $db_user = 'root';

  private function __construct()
  {
    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC //make the default fetch be an associative array
    ];

    try {
      $this->connection = new PDO(
        "mysql:host={$this->host};dbname={$this->db_name}",
        $this->db_user,
        $this->db_password,
        $options
      );
    } catch (PDOException $exc) {
      $this->error = true;
    }
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new DatabaseConnection();
    }
    return self::$instance;
  }

  public function getConnection()
  {
    return $this->connection;
  }

  public function getError()
  {
    return $this->error;
  }

  public function getErrorMsg()
  {
    return $this->error_msg;
  }
}
