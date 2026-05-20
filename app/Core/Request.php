<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Core;

class Request
{
    public function getInt(string $name, ?int $default = null): ?int
    {
        $value = $_GET[$name] ?? null;

        if ($value === null) {
            return $default;
        }

        if (!is_scalar($value)) {
            return $default;
        }

        $value = trim((string) $value);
        if (filter_var($value, FILTER_VALIDATE_INT) === false) {
            return $default;
        }

        return (int) $value;
    }

    public function getString(string $name, string $default = ''): string
    {
        $value = $_GET[$name] ?? null;

        if (!is_scalar($value)) {
            return $default;
        }

        return trim((string) $value);
    }
}
