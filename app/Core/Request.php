<?php

namespace Abelohost\TestApp\Core;

class Request
{
    public function getParameter(string $name, mixed $default): mixed
    {
        return $_GET[$name] ?? $default;
    }
}
