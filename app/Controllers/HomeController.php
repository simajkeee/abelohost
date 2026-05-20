<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Controllers;

use Abelohost\TestApp\Core\Controller;
use Abelohost\TestApp\Core\View;
use Abelohost\TestApp\Repositories\CategoryRepository;
use Abelohost\TestApp\Services\ArticlesMapper;

class HomeController extends Controller
{
    public function __construct(
        View $view,
        private readonly ArticlesMapper $mapper,
        private readonly CategoryRepository $categoryRepo,
    )
    {
        parent::__construct($view);
    }

    public function index(): void
    {
        $categoriesWithArticles = $this->mapper->flattenCategoriesWithLatestArticles(
            $this->categoryRepo->getCategoriesWithLatestArticles()
        );

        $this->render('home.tpl', [
            'categoriesWithArticles' => $categoriesWithArticles,
        ]);
    }
}
