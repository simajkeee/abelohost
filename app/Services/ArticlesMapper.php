<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Services;

class ArticlesMapper
{
    public function flattenCategoriesWithLatestArticles(array $categoriesWithArticles): array
    {
        $categoriesWithArticlesFlatten = [];
        foreach ($categoriesWithArticles as $ca) {
            $categoryId = $ca['category_id'];
            if (!isset($categoriesWithArticlesFlatten[$categoryId])) {
                $categoriesWithArticlesFlatten[$categoryId] = [
                    'id' => $categoryId,
                    'title' => $ca['category_title'],
                    'description' => $ca['category_description'],
                    'articles' => [],
                ];
            }

            $categoriesWithArticlesFlatten[$categoryId]['articles'][] = [
                'id' => $ca['article_id'],
                'image' => $ca['image'],
                'title' => $ca['article_title'],
                'description' => $ca['article_description'],
                'view_count' => $ca['view_count'],
                'published_at' => $ca['published_at'],
                'created_at' => $ca['created_at'],
            ];
        }

        return $categoriesWithArticlesFlatten;
    }
}
