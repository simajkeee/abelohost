<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Helpers;

class Debugger
{
    public static function dd($var)
    {
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
        die();
    }
}
