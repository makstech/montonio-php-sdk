<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

if (!$accessKey = getenv('ACCESS_KEY')) {
    throw new InvalidArgumentException('ACCESS_KEY env variable not set');
}
if (!$secretKey = getenv('SECRET_KEY')) {
    throw new InvalidArgumentException('SECRET_KEY env variable not set');
}

define('ACCESS_KEY', $accessKey);
define('SECRET_KEY', $secretKey);
