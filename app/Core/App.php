<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Core;

use Abelohost\TestApp\Controllers\HomeController;
use Abelohost\TestApp\Factories\ConnectionFactory;
use Abelohost\TestApp\Repositories\ArticleRepository;
use Abelohost\TestApp\Repositories\CategoryRepository;

class App
{
    public function run(): void
    {
        $pdo = ConnectionFactory::getPDO();
        $categoryRepo = new CategoryRepository($pdo);
        $articleRepo = new ArticleRepository($pdo);

        $homeController = new HomeController(new View(), $categoryRepo, $articleRepo);
        $homeController->index();
    }
}
