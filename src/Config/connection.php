<?php
require_once __DIR__ . '/../Components/DataBase/MySQLdatabase.php';
require_once __DIR__ . '/../Core/interfaces/Database.php';
require_once __DIR__ . '/../../vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$dsn = [
    'host' => getenv('DB_HOST') ?: '127.0.0.1',
    'pass' => getenv('DB_PASS') ?: '',
    'port' => getenv('DB_PORT') ?: '3306',
    'user' => getenv('DB_USER') ?: 'root',
    'dbName' => getenv('DB_NAME') ?: 'attendance',
];
$pdo = new PDO("mysql:host={$dsn['host']};port={$dsn['port']};dbname={$dsn['dbName']};charset=utf8mb4",
    $dsn['user'], $dsn['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db = new MySQLdatabase($pdo);
