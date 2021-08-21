<?php

require_once __DIR__.'/vendor/autoload.php';

use app\core\Application;

// Loading the .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Can access the .env file values using $_ENV superglobal
$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];

$app = new Application(__DIR__, $config);

$app->database->applyMigrations();