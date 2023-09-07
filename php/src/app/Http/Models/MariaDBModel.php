<?php

namespace App\Http\Models;

use App\DB\Connection;

class MariaDBModel extends Model {

    protected static Connection $connection;

    public static function setConnection(Connection $connection) {
        static::$connection = $connection;
    }

    public function __construct() {
        parent::__construct(static::$connection);
    }

    public function setTransaction() {
        $this->query('START TRANSACTION;');
    }

    public function commitTransaction() {
        $this->query('COMMIT;');
    }

}
