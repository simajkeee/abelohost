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
        if (!file_get_contents($schemaPath)) {
            throw new RuntimeException('schema.sql is missing');
        }

        $sql = file_get_contents($schemaPath);

        $this->pdo->exec($sql);
    }

}
