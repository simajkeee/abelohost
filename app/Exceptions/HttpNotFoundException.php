<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Exceptions;

use Exception;
use Throwable;

class HttpNotFoundException extends Exception
{
    public function __construct(string $message = "404 not found", ?Throwable $previous = null)
    {
        parent::__construct($message, 404, $previous);
    }
}
