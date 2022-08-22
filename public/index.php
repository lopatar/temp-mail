<?php

use app\config;
use app\database\connection;
use app\routes;
use sdk\app;
use sdk\render\view;

require __DIR__ . '/../vendor/autoload.php';

view::set_default_path(__DIR__ . '/../app/views/');
connection::init(config::MYSQL_HOST, config::MYSQL_USER, config::MYSQL_PASS, config::MYSQL_DB);

$app = new app;
routes::init($app);
$app->run();