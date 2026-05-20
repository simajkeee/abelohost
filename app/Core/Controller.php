<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Core;

abstract class Controller
{
    public function __construct(protected readonly View $view)
    {
    }

    protected function render(string $template, array $data): void
    {
        $this->view->render($template, $data);
    }
}
