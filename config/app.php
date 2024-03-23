<?php

define('APP_TITLE', 'mvc');
define('BASE_URL', 'http://localhost:8000');
define('BASE_DIR', realpath(__DIR__ . '/../'));

$temp = str_replace(BASE_URL, '', explode('?', $_SERVER['REQUEST_URI'])[0]);
$temp === '/' ? $temp = '' : $temp = substr($temp, 1);

define('CURRENT_ROUTE', $temp);

global $routes;
$routes = [
    'get' => [],
    'post' => [],
    'put' => [],
    'delete' => []
];