<?php

declare(strict_types=1);

namespace Integration;

use Abelohost\TestApp\Repositories\ArticleRepository;
use PDO;
use PHPUnit\Framework\TestCase;

class ArticleRepositoryTest extends TestCase
{
    private PDO $pdo;

    private ArticleRepository $repository;

    protected function setUp(): void
    {
        $this->pdo = new PDO(
            sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                $_ENV['MYSQL_HOST'],
                $_ENV['MYSQL_PORT'],
                $_ENV['MYSQL_TEST_DATABASE'],
            ),
            $_ENV['MYSQL_USER'],
            $_ENV['MYSQL_PASSWORD'],
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]
        );

        $this->resetSchema();
        $this->repository = new ArticleRepository($this->pdo);
    }

    public function testFindByIdReturnsPublishedArticle(): void
    {
        $this->pdo->exec("
            INSERT INTO articles (id, image, title, description, content, view_count, published_at, created_at)
            VALUES (1, 'test.jpg', 'Published article', 'Description', 'Content', 10, NOW(), NOW())
        ");

        $article = $this->repository->findById(1);

        self::assertNotNull($article);
        self::assertSame(1, (int) $article['id']);
        self::assertSame('Published article', $article['title']);
    }

    public function testFindByIdHidesUnpublishedArticles(): void
    {
        $this->pdo->exec("
            INSERT INTO articles (id, image, title, description, content, view_count, published_at, created_at)
            VALUES (1, 'test.jpg', 'Published article', 'Description', 'Content', 10, NULL, NOW())
        ");

        $article = $this->repository->findById(1);
        self::assertNull($article);
    }

    public function testFindByIdHidesFutureArticles(): void
    {
        $this->pdo->exec("
            INSERT INTO articles (id, image, title, description, content, view_count, published_at, created_at)
            VALUES (1, 'test.jpg', 'Published article', 'Description', 'Content', 10, DATE_ADD(NOW(), INTERVAL 1 YEAR), NOW())
        ");

        $article = $this->repository->findById(1);
        self::assertNull($article);
    }

    public function testGetByCategoryReturnsOnlyArticlesFromRequestedCategory(): void
    {
        $this->insertCategory(1, 'Web Development');
        $this->insertCategory(2, 'Hosting');
        $this->insertArticle(1, 'Category 1 article', 10, '2026-05-10 10:00:00');
        $this->insertArticle(2, 'Category 2 article', 20, '2026-05-11 10:00:00');
        $this->attachArticleToCategory(1, 1);
        $this->attachArticleToCategory(2, 2);

        $articles = $this->repository->getByCategory(1, 'date', 10, 0);

        self::assertCount(1, $articles);
        self::assertSame(1, (int) $articles[0]['id']);
        self::assertSame(1, (int) $articles[0]['category_id']);
    }

    public function testGetByCategorySortsByViews(): void
    {
        $this->insertCategory(1, 'Web Development');
        $this->insertArticle(1, 'Low views', 10, '2026-05-10 10:00:00');
        $this->insertArticle(2, 'High views', 50, '2026-05-09 10:00:00');
        $this->insertArticle(3, 'Medium views', 25, '2026-05-11 10:00:00');
        $this->attachArticleToCategory(1, 1);
        $this->attachArticleToCategory(2, 1);
        $this->attachArticleToCategory(3, 1);

        $articles = $this->repository->getByCategory(1, 'views', 10, 0);

        self::assertSame([2, 3, 1], array_map(static fn (array $article): int => (int) $article['id'], $articles));
    }

    public function testGetByCategoryPaginatesSortedByDate(): void
    {
        $this->insertCategory(1, 'Web Development');
        $this->insertArticle(1, 'Oldest article', 10, '2026-05-09 10:00:00');
        $this->insertArticle(2, 'Newest article', 20, '2026-05-11 10:00:00');
        $this->insertArticle(3, 'Middle article', 30, '2026-05-10 10:00:00');
        $this->attachArticleToCategory(1, 1);
        $this->attachArticleToCategory(2, 1);
        $this->attachArticleToCategory(3, 1);

        $articles = $this->repository->getByCategory(1, 'date', 1, 1);

        self::assertCount(1, $articles);
        self::assertSame(3, (int) $articles[0]['id']);
    }

    public function testCountByCategoryCountsOnlyPublishedArticles(): void
    {
        $this->insertCategory(1, 'Web Development');
        $this->insertArticle(1, 'Published article', 10, '2026-05-10 10:00:00');
        $this->insertArticle(2, 'Unpublished article', 20, null);
        $this->insertArticle(3, 'Future article', 30, '2030-05-10 10:00:00');
        $this->attachArticleToCategory(1, 1);
        $this->attachArticleToCategory(2, 1);
        $this->attachArticleToCategory(3, 1);

        self::assertSame(1, $this->repository->countByCategory(1));
    }

    public function testIncrementViewsIncreasesViewCount(): void
    {
        $this->insertArticle(1, 'Published article', 5, '2026-05-10 10:00:00');

        $this->repository->incrementViews(1);

        $viewCount = $this->pdo
            ->query('SELECT view_count FROM articles WHERE id = 1')
            ->fetchColumn();

        self::assertSame(6, (int) $viewCount);
    }

    public function testGetRelatedExcludesCurrentArticleAndRespectsLimit(): void
    {
        $this->insertCategory(1, 'Web Development');
        $this->insertArticle(1, 'Current article', 10, '2026-05-10 10:00:00');
        $this->insertArticle(2, 'Related article 1', 20, '2026-05-11 10:00:00');
        $this->insertArticle(3, 'Related article 2', 30, '2026-05-12 10:00:00');
        $this->insertArticle(4, 'Related article 3', 40, '2026-05-13 10:00:00');
        $this->attachArticleToCategory(1, 1);
        $this->attachArticleToCategory(2, 1);
        $this->attachArticleToCategory(3, 1);
        $this->attachArticleToCategory(4, 1);

        $articles = $this->repository->getRelated(1, [1], 2);
        $articleIds = array_map(static fn (array $article): int => (int) $article['id'], $articles);

        self::assertCount(2, $articles);
        self::assertSame([4, 3], $articleIds);
        self::assertNotContains(1, $articleIds);
    }

    private function resetSchema(): void
    {
        $this->pdo->exec('DROP TABLE IF EXISTS article_category');
        $this->pdo->exec('DROP TABLE IF EXISTS articles');
        $this->pdo->exec('DROP TABLE IF EXISTS categories');

        $schema = file_get_contents(__DIR__ . '/../../database/schema.sql');
        if ($schema === false) {
            self::fail('Cannot read database/schema.sql');
        }

        $this->pdo->exec($schema);
    }

    private function insertCategory(int $id, string $title): void
    {
        $sth = $this->pdo->prepare('
            INSERT INTO categories (id, title, description, created_at)
            VALUES (?, ?, ?, NOW())
        ');
        $sth->execute([$id, $title, $title . ' description']);
    }

    private function insertArticle(int $id, string $title, int $viewCount, ?string $publishedAt): void
    {
        $sth = $this->pdo->prepare('
            INSERT INTO articles (id, image, title, description, content, view_count, published_at, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ');
        $sth->execute([
            $id,
            'test.jpg',
            $title,
            $title . ' description',
            $title . ' content',
            $viewCount,
            $publishedAt,
        ]);
    }

    private function attachArticleToCategory(int $articleId, int $categoryId): void
    {
        $sth = $this->pdo->prepare('
            INSERT INTO article_category (article_id, category_id)
            VALUES (?, ?)
        ');
        $sth->execute([$articleId, $categoryId]);
    }
}
