<?php
use Components\Services\ManagerFactory;
use Components\Repositories\MySQLRepositorie;
use Controllers\Router;


ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../src/Config/connection.php';


$method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];
$base_url = 'attendance/public';

$repo = new MySQLRepositorie($db);
$factory = new ManagerFactory($repo);

$router = new Router($base_url, $repo, $factory);
$router->router($request_uri);

