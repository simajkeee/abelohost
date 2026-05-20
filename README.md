# AbeloHost PHP Blog Test Assignment

Simple blog website built with pure PHP, MySQL, and Smarty. The app implements categories, articles, category sorting and pagination, article pages with related posts, and database seeding.

## Tech Stack

- PHP 8.4 in Docker
- MySQL 8
- Smarty 5
- Nginx + PHP-FPM
- Composer
- Pure PHP, no framework

## Features

- Home page with categories that contain published articles
- 3 latest articles per category on the home page
- Category page with article list
- Sorting by publication date and view count
- Pagination on category pages
- Article page with image, content, categories, view count, and related articles
- Seed data for categories, articles, and article-category relations
- Docker environment

## Installation

Create your local environment file:

```bash
cp .env.example .env
```

Start the containers:

```bash
docker compose up -d
```

Install dependencies:

```bash
docker compose exec php composer install
```

Create the database schema:

```bash
docker compose exec php php bin/migrate.php
```

Seed categories and articles:

```bash
docker compose exec php php bin/seed.php
```

Open the app:

```text
http://localhost:8080
```

## Useful URLs

```text
/
/category?id=1
/category?id=1&sort=views
/category?id=1&sort=date&page=2&per_page=3
/article?id=1
```

## Notes

- `published_at` controls public visibility. Articles with future or empty `published_at` are not shown publicly.
- Article views increment once per browser session per article.
- Smarty compiled templates are written to `storage/smarty/compile`.

## AI Usage

AI assistance was used for planning, code review, debugging guidance, and wording support. Implementation decisions and final code were reviewed manually.
