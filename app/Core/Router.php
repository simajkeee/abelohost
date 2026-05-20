<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Core;

use Closure;
use RuntimeException;

class Router
{
    private array $routes = [];

    public function get(string $path, Closure|array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH);
        $handler = $this->routes[$method][$path] ?? null;

        try {
            if (null === $handler) {
                throw new RuntimeException("404 not found", 404);
            }

            call_user_func($handler);
        } catch (\Throwable $e) {
            if ($e->getCode() === 404) {
                $this->notFound($e->getMessage());
                return;
            }

            throw $e;
        }
    }

    private function notFound($msg)
    {
        http_response_code(404);
        echo $msg;
    }
}
