<?php

declare(strict_types=1);

namespace IWD\Templator\Service;

use IWD\Templator\Dto\Renderable;
use PHPUnit\Framework\TestCase;
use stdClass;

class RendererTest extends TestCase
{
    private static Renderer $renderer;

    public function setUp(): void
    {
        self::$renderer = new Renderer();

        parent::setUp();
    }

    public function testStringRender(): void
    {
        $renderable = new Renderable(
            template: 'My first {{ variable }} content',
            variables: [
                'variable' => 'rendered',
            ]
        );

        $expected = 'My first rendered content';

        self::assertSame(
            $expected,
            self::$renderer->render($renderable)
        );
    }

    public function testManyStringRender(): void
    {
        $renderable = new Renderable(
            template: <<<TEXT
            ASdniond {{ a | tablize | pluralize  }} wefni {{b.name | tablize}}  djqdjq {{ c}} f466wef [{ }] wd {{}}
            TEXT,
            variables: [
                'a' => '!',
                'b' => '*',
                'c' => '+',
            ]
        );

        $expected = 'My first rendered content';

        self::assertSame(
            $expected,
            self::$renderer->render($renderable)
        );
    }

    public function testStringRenderNoSpace(): void
    {
        $renderable = new Renderable(
            template: 'My first {{variable}} content',
            variables: [
                'variable' => 'rendered',
            ]
        );

        $expected = 'My first rendered content';

        self::assertSame(
            $expected,
            self::$renderer->render($renderable)
        );
    }

    public function testObjectStdClassRender(): void
    {
        $renderable = new Renderable(
            template: 'My name is {{ obj.name }}!',
            variables: [
                'obj' => $obj = new stdClass(),
            ]
        );
        $obj->name = 'Alexander';

        $expected = 'My name is Alexander!';

        self::assertSame(
            $expected,
            self::$renderer->render($renderable)
        );
    }

    public function testObjectAnonymousRender(): void
    {
        $renderable = new Renderable(
            template: 'My name is {{ obj.name }}!',
            variables: [
                'obj' => new class () {
                    public string $name = 'Alexander';
                },
            ]
        );

        $expected = 'My name is Alexander!';

        self::assertSame(
            $expected,
            self::$renderer->render($renderable)
        );
    }

    public function testArrayRender(): void
    {
        $renderable = new Renderable(
            template: 'My name is {{ obj.name }}!',
            variables: [
                'obj' => [
                    'name' => 'Alexander',
                ],
            ]
        );

        $expected = 'My name is Alexander!';

        self::assertSame(
            $expected,
            self::$renderer->render($renderable)
        );
    }
}
