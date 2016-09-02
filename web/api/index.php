<?php
/**
 * @copyright Copyright (C) 2016. Max Dark maxim.dark@gmail.com
 * @license MIT; see LICENSE.txt
 */

use useless\database\Database;
use useless\database\MySqlStorage;
use useless\rest\Router;

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require_once '../../vendor/autoload.php';
/** @var array $routes */
$routes = require_once '../../etc/routes.php';
/** @var \useless\database\Config $config */
$config = require_once '../../etc/db.php';

$storage = new MySqlStorage(
    $config->getPrefix(),
    Database::instance($config)
);

$router = new Router(
    $storage,
    $routes
);
$method = $_SERVER['REQUEST_METHOD'];
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$result = $router->dispatch($method, $url);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode($result, JSON_UNESCAPED_UNICODE);
