<?php

declare(strict_types=1);

namespace IWD\Templator\Service;

use IWD\Templator\Dto\Renderable;
use PHPUnit\Framework\TestCase;

class RendererTest extends TestCase
{
    public function testSimpleRender(): void
    {
        $renderable = new Renderable(
            template: 'My first {{ variable }} content',
            variables: [
                'variable' => 'rendered'
            ]
        );
        $renderer = new Renderer();

        $expected = 'My first rendered content';

        self::assertSame(
            $expected,
            $renderer->render($renderable)
        );
    }
}
