<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Core;

use Abelohost\TestApp\Factories\ConnectionFactory;

class App
{
    public function run(): void
    {
        $pdo = ConnectionFactory::getPDO();

        echo "App is running";
    }
}
