<?php

declare(strict_types=1);

use Abelohost\TestApp\Core\Migration;
use Abelohost\TestApp\Factories\ConnectionFactory;

include_once 'boot.php';

new Migration(ConnectionFactory::getPDO())
    ->run();