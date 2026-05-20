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
        $view = new View();

        $categoryRepository = new CategoryRepository($pdo);
        $articleRepository = new ArticleRepository($pdo);

        $router = new Router();

        $router->get('/', [new HomeController($view, $categoryRepository, $articleRepository), 'index']);
//        $router->get('/category', [new CategoryController($view, $categoryRepository, $articleRepository), 'show']);
//        $router->get('/article', [new ArticleController($view, $categoryRepository, $articleRepository), 'show']);

        $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    }
}
