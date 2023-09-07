<?php

require_once __DIR__.'/vendor/autoload.php';

define('VIEW_PATH', __DIR__.'/app/Http/Views');
define('CONFIG_PATH', __DIR__.'/app/Config');
define('ROUTES_PATH', __DIR__.'/app/Http/Routes');

$configRabbitMq = require_once CONFIG_PATH.'/rabbitmq.php';
$configMariaDB = require_once CONFIG_PATH.'/mariadb.php';

$mariadbConnection = new \App\DB\Connection($configMariaDB);

\App\Http\Models\MariaDBModel::setConnection($mariadbConnection);

App\Rabbitmq\Client::setConfig($configRabbitMq);

$routes = require_once ROUTES_PATH.'/web.php';

(new App\App())->handle($routes);