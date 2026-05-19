<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Core;

use PDO;
use RuntimeException;
use Throwable;

class Seed
{
    private const string SEED_PATH = '/database/seed.sql';

    public function __construct(private readonly PDO $pdo)
    {
    }

    public function run(): void
    {
        $seedPath = APP_ROOT . self::SEED_PATH;
        if (!file_exists($seedPath)) {
            throw new RuntimeException('seed.sql is missing');
        }

        if ($this->hasSeedData()) {
            echo "The tables not empty. Skipping...\n";
            return;
        }

        $sql = file_get_contents($seedPath);
        if ($sql === false || trim($sql) === '') {
            throw new RuntimeException('seed.sql is empty or cannot be read');
        }

        $this->pdo->beginTransaction();

        try {
            $this->pdo->exec($sql);
            $this->pdo->commit();
        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            throw $e;
        }
    }

    private function hasSeedData(): bool
    {
        $categoriesCount = (int) $this->pdo
            ->query('SELECT COUNT(*) FROM categories')
            ->fetchColumn();

        $articlesCount = (int) $this->pdo
            ->query('SELECT COUNT(*) FROM articles')
            ->fetchColumn();

        return $categoriesCount > 0 || $articlesCount > 0;
    }
}
