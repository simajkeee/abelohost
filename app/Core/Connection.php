<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Core;

use PDO;

readonly class Connection
{
    public function __construct(
        private string $host,
        private string $port,
        private string $database,
        private string $username,
        private string $password,
    ) {
    }

    public function initialize(): PDO
    {
        return new PDO(
            "mysql:host={$this->host};port={$this->port};dbname={$this->database};charset=utf8mb4",
            $this->username,
            $this->password,
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]
        );
    }
}
