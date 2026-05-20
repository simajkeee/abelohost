<?php

namespace Abelohost\TestApp\Services;

class Request
{
    public function getParameter(string $name, mixed $default): mixed
    {
        return $_GET[$name] ?? $default;
    }
}
