<?php
require_once __DIR__ . '../Components/DataBase/MySQLdatabase.php';
require_once __DIR__ . '../Core/interfaces/Database.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '../');
$dotenv->load();
$dsn = [
    'host' => getenv('DB_HOST'),
    'pass' => getenv('DB_PASS'),
    'port' => getenv('DB_PORT'),
    'user' => getenv('DB_USER'),
    'dbName' => getenv('DB_NAME')
];
$pdo = new PDO("mysql:host={$dns['host']}dbname={$dns['dbName']}", $dsn['user'], $dsn['pass']);
$db = new MySQLdatabase($pdo);
