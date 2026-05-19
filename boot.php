<?php

declare(strict_types=1);

const APP_ROOT = __DIR__;

$autoload = APP_ROOT . '/vendor/autoload.php';

if (!file_exists($autoload)) {
    throw new LogicException('Autoload is not generated. Run composer install.');
}

require_once $autoload;

$dotenv = Dotenv\Dotenv::createImmutable(APP_ROOT);
$dotenv->load();
