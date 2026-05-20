<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Repositories;

class CategoryRepository extends AbstractRepository
{
    public function getAll(): array
    {
        $sth = $this->pdo->query("SELECT id, title, description, created_at FROM categories");

        return $sth->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $sth = $this->pdo->prepare('SELECT id, title, description, created_at FROM categories WHERE id = ?');
        $sth->execute([$id]);

        return $sth->fetch() ?: null;
    }

    public function getByArticleId(int $id): array
    {
        $sth = $this->pdo->prepare('
            SELECT c.id, c.title, c.description, c.created_at FROM categories as c
            INNER JOIN article_category as ac
            ON ac.category_id = c.id
            WHERE ac.article_id = ?
        ');
        $sth->execute([$id]);

        return $sth->fetchAll();
    }
}
