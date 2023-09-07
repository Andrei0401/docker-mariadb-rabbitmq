<?php

namespace App\Http\Models;

use App\DB\Connection;

class Model {

    protected $connectionDB;

    public function __construct(Connection $connection) {
        $this->connectionDB =  $connection;
    }

    public function query($query, array $params = array()) {
        $pdo = $this->connectionDB->getPdo();
        $sth = $pdo->prepare($query);
        $sth->execute($params);
        $results = $sth->fetchAll();
        return $results;
    }
}
