<?php

require "../vendor/autoload.php";

use Slim\Factory\AppFactory;

$app = AppFactory::create();

$config = require "../src/config.php";
$db = new PDO(
    "mysql:dbname={$config['DB_DATABASE']};host={$config['DB_HOST']};charset=utf8mb4",
    $config['DB_USER'],
    $config['DB_PASS']
);

$routes = require "../src/routes.php";
$routes($app);

$app->run();