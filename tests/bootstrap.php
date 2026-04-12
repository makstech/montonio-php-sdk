<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

define('ACCESS_KEY', $_ENV['ACCESS_KEY'] ?? getenv('ACCESS_KEY') ?: '');
define('SECRET_KEY', $_ENV['SECRET_KEY'] ?? getenv('SECRET_KEY') ?: str_repeat('x', 32));
