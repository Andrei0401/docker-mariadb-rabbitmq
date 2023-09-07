<?php

namespace App\DB;

class Connection
{
    protected $pdo;

    public function __construct(array $config) {

        try {
          $this->pdo = new \PDO(...$config);
        }
        catch (Exception $e) {
          error_log($e->getMessage());
          exit('Something bad happened');
        }
    }

    public function getPdo() {
        return $this->pdo;
    }
}
