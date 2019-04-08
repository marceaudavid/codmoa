<?php

class Database
{
  private $dbname;
  private $user;
  private $password;
  private $host = "localhost";
  private $port = 5432;
  private $pdo;

  public function __construct(string $dbname, string $user, string $password)
  {
    $this->dbname = $dbname;
    $this->user = $user;
    $this->password = $password;
  }

  public function connect()
  {
    if ($this->pdo === null) {
      $pdo = new PDO("pgsql:host=$this->host;port=$this->port;dbname=$this->dbname", $this->user, $this->password, null);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->pdo = $pdo;
    } else {
      return $this->pdo;
    }
  }

  public function query(string $query)
  {
    $query = $this->pdo->prepare($query);
    $query->execute();
    $res = $query->fetchAll();
    return $res;
  }

  public function getColumnsName(string $query)
  {
    $query = $this->pdo->prepare($query);
    $query->execute();
    $res = $query->fetchAll();
    for ($i = 0; $i < $query->columnCount(); $i++) {
      $col = $query->getColumnMeta($i);
      $columns[] = $col['name'];
    }
    return $columns;
  }
}