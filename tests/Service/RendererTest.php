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
                **** {{f.name | classify}} **** {{ a | tablize | pluralize  }} **** {{b | tablize}}  **** {{ c}} **** [{ }] **** {{}}
                TEXT,
            variables: [
                'f' => new class () {
                    public string $name = 'F_NAME';
                },
                'a' => 'AAAA',
                'b' => 'BBBB',
                'c' => 'CCCC',
            ]
        );

        $expected = '**** F_NAME **** AAAA **** BBBB  **** CCCC **** [{ }] **** {{}}';

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
                    //todo: тут встроенный объект еще добавить, и обратиться к его атрибуту
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
            template: 'My name is {{ obj.name.first }} {{ obj.name.last }}!',
            variables: [
                'obj' => [
                    'name' => [
                        'first' => 'Ivan',
                        'last' => 'Petrov',
                    ],
                ],
            ]
        );

        $expected = 'My name is Ivan Petrov!';

        self::assertSame(
            $expected,
            self::$renderer->render($renderable)
        );
    }
}
