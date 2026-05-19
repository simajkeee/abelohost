<?php

declare(strict_types=1);

use Abelohost\TestApp\Core\Seed;
use Abelohost\TestApp\Factories\ConnectionFactory;

include_once 'boot.php';

new Seed(ConnectionFactory::getPDO())
    ->run();
