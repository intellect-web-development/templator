<?php

declare(strict_types=1);

namespace IWD\Templator\Service;

use IWD\Templator\Dto\Renderable;
use IWD\Templator\Dto\NormalizeVariable;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class Renderer
{
    private PropertyAccessor $propertyAccessor;

    public function __construct()
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    public function render(Renderable $renderable): string
    {
        $normalizeVariables = [];
        preg_match_all('/{{(.+?)}}/', $renderable->template, $matches);
        foreach ($matches[0] as $match) {
            $normalizeVariables[] = new NormalizeVariable($match);
        }

        //todo: с массивами синтаксис такой. С объектами просто через точку. В случае, когда работаем с массивом
        // - всегда надо преоброазовывать к [aa][bb] (в нашем случае всегда, ибо мы передаем ТОЛЬКО массив в Renderable)
//        $arr = [
//            'aa' => [
//                'bb' => 'cc',
//            ],
//        ];
//        var_dump(
//            $this->propertyAccessor->getValue($arr, '[aa][bb]')
//        );
        //        var_dump($normalizeVariables);
        //        exit;

        $template = $renderable->template;
        foreach ($normalizeVariables as $variable) {
            $variableValue = $this->propertyAccessor->getValue($renderable->variables, "[{$variable->targetVariable}]");

            if (is_object($variableValue)) {
                $withoutRootVariable = explode('.', $variable->targetVariable);
                array_shift($withoutRootVariable);

                $template = str_replace(
                    $variable->raw,
                    (string) $this->propertyAccessor->getValue($variableValue, implode('.', $withoutRootVariable)),
                    $template
                );
            }
            if (is_string($variableValue) || is_numeric($variableValue)) {
                $template = str_replace($variable->raw, (string) $variableValue, $template);
            }
        }

        return $template;
    }
}
