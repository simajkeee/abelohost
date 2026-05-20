<?php

declare(strict_types=1);

use Abelohost\TestApp\Core\Request;
use PHPUnit\Framework\Attributes\After;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    #[After]
    public function resetQueryParameters(): void
    {
        $_GET = [];
    }

    public function testGetIntReturnsIntegerForValidQueryParameter(): void
    {
        $_GET['id'] = '42';

        self::assertSame(42, (new Request())->getInt('id'));
    }

    public function testGetIntReturnsDefaultForInvalidQueryParameter(): void
    {
        $_GET['id'] = ['42'];

        self::assertSame(1, (new Request())->getInt('id', 1));
    }

    public function testGetStringReturnsTrimmedScalarValue(): void
    {
        $_GET['sort'] = ' views ';

        self::assertSame('views', (new Request())->getString('sort', 'date'));
    }

    public function testGetStringReturnsDefaultForArrayValue(): void
    {
        $_GET['sort'] = ['views'];

        self::assertSame('date', (new Request())->getString('sort', 'date'));
    }
}
