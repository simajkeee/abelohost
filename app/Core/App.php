<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Core;

use Abelohost\TestApp\Controllers\ArticleController;
use Abelohost\TestApp\Controllers\CategoryController;
use Abelohost\TestApp\Controllers\HomeController;
use Abelohost\TestApp\Factories\ConnectionFactory;
use Abelohost\TestApp\Repositories\ArticleRepository;
use Abelohost\TestApp\Repositories\CategoryRepository;
use Abelohost\TestApp\Services\ArticlesMapper;
use Abelohost\TestApp\Services\Request;

class App
{
    public function run(): void
    {
        $pdo = ConnectionFactory::getPDO();
        $view = new View();
        $request = new Request();

        $categoryRepository = new CategoryRepository($pdo);
        $articleRepository = new ArticleRepository($pdo);

        $router = new Router();

        $router->get('/', [new HomeController($view, new ArticlesMapper(), $categoryRepository), 'index']);
        $router->get('/category', [new CategoryController($view, $request, $categoryRepository, $articleRepository), 'show']);
        $router->get('/article', [new ArticleController($view, $request, $categoryRepository, $articleRepository), 'show']);

        $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    }
}
