<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Exceptions;

use Exception;

class HttpNotFoundException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        if (empty(trim($message))) {
            $message = "404 not found";
        }

        if ($code === 0) {
            $code = 404;
        }

        parent::__construct($message, $code, $previous);
    }
}
