<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Core;

use RuntimeException;

class Migration
{
    private const string SCHEMA_PATH = '/database/schema.sql';

    public function __construct(private readonly \PDO $pdo)
    {
    }

    public function run(): void
    {
        $schemaPath = APP_ROOT . self::SCHEMA_PATH;
        $sql = file_get_contents($schemaPath);
        if ($sql === false || $sql === '') {
            throw new RuntimeException('schema.sql is missing');
        }

        $this->pdo->exec($sql);
    }

}
