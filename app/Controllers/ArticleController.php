<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Controllers;

use Abelohost\TestApp\Core\Controller;
use Abelohost\TestApp\Core\View;
use Abelohost\TestApp\Exceptions\HttpNotFoundException;
use Abelohost\TestApp\Repositories\ArticleRepository;
use Abelohost\TestApp\Repositories\CategoryRepository;
use Abelohost\TestApp\Core\Request;

class ArticleController extends Controller
{
    public function __construct(
        View $view,
        private readonly Request $request,
        private readonly CategoryRepository $categoryRepo,
        private readonly ArticleRepository $articleRepo,
    ) {
        parent::__construct($view);
    }

    public function show()
    {
        $articleId = $this->request->getInt('id');
        if (null === $articleId || $articleId < 1) {
            throw new HttpNotFoundException();
        }

        $article = $this->articleRepo->findById($articleId);
        if (empty($article)) {
            throw new HttpNotFoundException();
        }

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $key = 'viewed_article_' . $articleId;
        if (!isset($_SESSION[$key])) {
            $this->articleRepo->incrementViews($articleId);
            $_SESSION[$key] = true;
            $article['view_count']++;
        }

        $categories = $this->categoryRepo->getByArticleId($articleId);
        $categoryIds = array_column($categories, 'id');
        $relatedArticles = $this->articleRepo->getRelated($articleId, $categoryIds);

        $this->view->render('article.tpl', [
            'article' => $article,
            'categories' => $categories,
            'relatedArticles' => $relatedArticles,
        ]);
    }
}
