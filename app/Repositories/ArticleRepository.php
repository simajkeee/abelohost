<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Repositories;

use PDO;

class ArticleRepository extends AbstractRepository
{
    public function getLatest(int $limit = 3): array
    {
        $sth = $this->pdo->prepare('
            SELECT id, image, title, description, content, view_count, published_at, created_at
            FROM articles
            WHERE published_at <= NOW()
            ORDER BY published_at DESC
            LIMIT ?
        ');
        $sth->bindValue(1, $limit, PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $sth = $this->pdo->prepare('
            SELECT id, image, title, description, content, view_count, published_at, created_at
            FROM articles
            WHERE published_at <= NOW() AND id = ?
        ');
        $sth->execute([$id]);

        return $sth->fetch() ?: null;
    }

    public function getByCategory(int $id): array
    {
        $sth = $this->pdo->prepare('
            SELECT a.id, a.image, a.title, a.description, a.content, a.view_count, a.published_at, a.created_at, ac.category_id
            FROM articles as a
            INNER JOIN article_category as ac
            ON ac.article_id = a.id
            WHERE a.published_at <= NOW() AND ac.category_id = ?
        ');
        $sth->execute([$id]);

        return $sth->fetchAll();
    }

    public function countByCategory(int $id): int
    {
        $sth = $this->pdo->prepare('
            SELECT COUNT(*) FROM articles as a
            INNER JOIN article_category as ac
            ON ac.article_id = a.id
            WHERE a.published_at <= NOW() AND ac.category_id = ?
        ');
        $sth->execute([$id]);

        return (int) $sth->fetchColumn();
    }

    public function incrementViews(int $id): void
    {
        $sth = $this->pdo->prepare('
            UPDATE articles
            SET view_count = view_count + 1
            WHERE id = ?
        ');

        $sth->execute([$id]);
    }

    public function getRelated(int $articleId, array $categoryIds, int $limit = 3): array
    {
        if (empty($categoryIds)) {
            return [];
        }

        $placeholders = implode(', ', array_fill(0, count($categoryIds), '?'));

        $sth = $this->pdo->prepare("
            SELECT DISTINCT a.id, a.image, a.title, a.description, a.content, a.view_count, a.published_at, a.created_at
            FROM articles a
            INNER JOIN article_category ac
            ON ac.article_id = a.id
            WHERE ac.category_id IN ($placeholders)
              AND a.id != ?
              AND a.published_at <= NOW()
            ORDER BY a.published_at DESC
            LIMIT ?
        ");

        $params = [
            ...$categoryIds,
            $articleId,
            $limit,
        ];

        foreach ($params as $index => $value) {
            $sth->bindValue($index + 1, (int) $value, PDO::PARAM_INT);
        }
        $sth->execute();

        return $sth->fetchAll();
    }
}
