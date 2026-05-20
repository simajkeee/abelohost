<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Core;

class App
{
    public function run(): void
    {
        $container = new Container();
        $router = new Router();

        $router->get('/', fn () => $container->homeController()->index());
        $router->get('/category', fn () => $container->categoryController()->show());
        $router->get('/article', fn () => $container->articleController()->show());

        $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    }
}
