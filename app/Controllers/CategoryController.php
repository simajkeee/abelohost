<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Controllers;

use Abelohost\TestApp\Core\Controller;
use Abelohost\TestApp\Core\View;
use Abelohost\TestApp\Exceptions\HttpNotFoundException;
use Abelohost\TestApp\Repositories\ArticleRepository;
use Abelohost\TestApp\Repositories\CategoryRepository;
use Abelohost\TestApp\Core\Request;

class CategoryController extends Controller
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

    public function show()
    {
        $categoryId = $this->request->getParameter('id', null);
        if (null === $categoryId) {
            throw new HttpNotFoundException();
        }

        $category = $this->categoryRepo->findById((int)$categoryId);
        if (empty($category)) {
            throw new HttpNotFoundException();
        }

        $page = (int) $this->request->getParameter('page', 1);
        if ($page < 1) {
            $page = 1;
        }

        $perPage = (int) $this->request->getParameter('per_page', 8);
        if ($perPage < 3) {
            $perPage = 3;
        } elseif ($perPage > 20) {
            $perPage = 20;
        }

        $totalArticles = $this->articleRepo->countByCategory($category['id']);
        $totalPages = (int) ceil($totalArticles / $perPage);
        if ($totalPages > 0 && $page > $totalPages) {
            $page = $totalPages;
        }

        $sortBy = trim($this->request->getParameter('sort', 'date'));
        if (!in_array($sortBy, ['date', 'views'], true)) {
            $sortBy = 'date';
        }

        $articles = $this->articleRepo->getByCategory(
            $category['id'],
            $sortBy,
            $perPage,
            ($page - 1) * $perPage,
        );

        $this->view->render('category.tpl', [
            'category' => $category,
            'articles' => $articles,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => $totalPages,
            'sort' => $sortBy,
        ]);
    }
}
