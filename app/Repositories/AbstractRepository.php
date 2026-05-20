<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Repositories;

use PDO;

class AbstractRepository
{
    public function __construct(protected readonly PDO $pdo)
    {
    }
}
