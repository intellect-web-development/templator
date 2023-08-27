<?php

declare(strict_types=1);

namespace IWD\Templator;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function testDayInDay(): void
    {
        $example = new Example();

        self::assertInstanceOf(Example::class, $example);
    }
}
