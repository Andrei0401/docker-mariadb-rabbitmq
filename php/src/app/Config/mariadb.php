<?php
return array(
    'dsn' => 'mysql:host=db;port=3306;dbname=test;',
    'username' => 'root',
    'password' => 'example',
    'options' => array(
        \PDO::ATTR_EMULATE_PREPARES   => false, // Disable emulation mode for "real" prepared statements
        \PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Disable errors in the form of exceptions
        \PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Make the default fetch be an associative array
    )
);