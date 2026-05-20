<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Controllers;

use Abelohost\TestApp\Core\Controller;
use Abelohost\TestApp\Core\View;
use Abelohost\TestApp\Repositories\ArticleRepository;
use Abelohost\TestApp\Repositories\CategoryRepository;
use Abelohost\TestApp\Services\Request;

class HomeController extends Controller
{
    public function __construct(
        View $view,
        private readonly Request $request,
        private readonly CategoryRepository $categoryRepo,
        private readonly ArticleRepository $articleRepo,
    )
    {
        parent::__construct($view);
    }

    public function index(): void
    {
        $limit = (int) $this->request->getParameter('limit', 3);
        if ($limit < 1) {
            $limit = 3;
        }

        if ($limit > 20) {
            $limit = 20;
        }

        $this->render('home.tpl', [
            'categories' => $this->categoryRepo->getAll(),
            'latestArticles' => $this->articleRepo->getLatest($limit),
        ]);
    }
}
