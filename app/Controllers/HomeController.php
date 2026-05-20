<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Controllers;

use Abelohost\TestApp\Core\Controller;
use Abelohost\TestApp\Core\View;
use Abelohost\TestApp\Repositories\ArticleRepository;
use Abelohost\TestApp\Repositories\CategoryRepository;

class HomeController extends Controller
{
    public function __construct(
        View $view,
        private readonly CategoryRepository $categoryRepo,
        private readonly ArticleRepository $articleRepo,
    )
    {
        parent::__construct($view);
    }

    public function index(): void
    {
        $this->render('home.tpl', [
            'categories' => $this->categoryRepo->getAll(),
            'latestArticles' => $this->articleRepo->getLatest(3),
        ]);
    }
}
