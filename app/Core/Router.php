<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Core;

use Abelohost\TestApp\Exceptions\HttpNotFoundException;
use Closure;
use Throwable;

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
                throw new HttpNotFoundException();
            }

            call_user_func($handler);
        } catch (HttpNotFoundException $e) {
            http_response_code(404);
            echo '404 not found';
        } catch (Throwable $e) {
            error_log($e);
            http_response_code(500);
            echo 'Internal server error';
        }
    }
}
