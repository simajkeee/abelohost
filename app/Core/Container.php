<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Core;

use Abelohost\TestApp\Controllers\ArticleController;
use Abelohost\TestApp\Controllers\CategoryController;
use Abelohost\TestApp\Controllers\HomeController;
use Abelohost\TestApp\Factories\ConnectionFactory;
use Abelohost\TestApp\Repositories\ArticleRepository;
use Abelohost\TestApp\Repositories\CategoryRepository;
use Abelohost\TestApp\Services\HomePageDataMapper;
use Abelohost\TestApp\Services\Request;
use PDO;

class Container
{
    private ?PDO $pdo = null;

    private ?View $view = null;

    private ?Request $request = null;

    private ?CategoryRepository $categoryRepository = null;

    private ?ArticleRepository $articleRepository = null;

    public function homeController(): HomeController
    {
        return new HomeController(
            $this->view(),
            new HomePageDataMapper(),
            $this->categoryRepository(),
        );
    }

    public function categoryController(): CategoryController
    {
        return new CategoryController(
            $this->view(),
            $this->request(),
            $this->categoryRepository(),
            $this->articleRepository(),
        );
    }

    public function articleController(): ArticleController
    {
        return new ArticleController(
            $this->view(),
            $this->request(),
            $this->categoryRepository(),
            $this->articleRepository(),
        );
    }

    private function pdo(): PDO
    {
        return $this->pdo ??= ConnectionFactory::getPDO();
    }

    private function view(): View
    {
        return $this->view ??= new View();
    }

    private function request(): Request
    {
        return $this->request ??= new Request();
    }

    private function categoryRepository(): CategoryRepository
    {
        return $this->categoryRepository ??= new CategoryRepository($this->pdo());
    }

    private function articleRepository(): ArticleRepository
    {
        return $this->articleRepository ??= new ArticleRepository($this->pdo());
    }
}
