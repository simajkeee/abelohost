<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Factories;

use Abelohost\TestApp\Core\Connection;
use LogicException;
use PDO;

class ConnectionFactory
{
    public static function getPDO(): PDO {
        $dbConfig = APP_ROOT . '/config/db.php';
        if (!file_exists($dbConfig)) {
            throw new LogicException("Can't find config/db.php file");
        }

        extract(include_once $dbConfig);

        return new Connection($host, $port, $database, $username, $password)
            ->initialize();
    }
}