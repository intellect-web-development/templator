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
        foreach ($matches[0] as $raw) {
            $normalizeVariables[] = new NormalizeVariable($raw);
        }

        //todo: с массивами синтаксис такой. С объектами просто через точку. В случае, когда работаем с массивом
        // - всегда надо преоброазовывать к [aa][bb] (в нашем случае всегда, ибо мы передаем ТОЛЬКО массив в Renderable)
        $arr = [
            'aa' => [
                'bb' => 'cc',
            ],
        ];
        var_dump(
            $this->propertyAccessor->getValue($arr, '[aa][bb]')
        );
        //        var_dump($normalizeVariables);
        //        exit;

        $template = $renderable->template;
        foreach ($normalizeVariables as $variable) {
            //            var_dump(
            //                $variable->targetVariable,
            //                $renderable->variables,
            //                $this->propertyAccessor->getValue($renderable->variables, $variable->targetVariable)
            //            );
            //            var_dump($renderable->variables, $variable);
            exit;
            //            if (is_string($value)) {
            //                $template = str_replace('{{ ' . $key . ' }}', $value, $template);
            //            }
            //            if (is_object($value)) {
            //                $template = str_replace('{{ ' . $key . ' }}', $this->propertyAccessor->getValue($value, $key), $template);
            //            }
            //            if (is_array($value)) {
            //                $template = str_replace('{{ ' . $key . ' }}', $value[$key], $template);
            //            }
        }
        //
        //        return $template;
        return '';
    }
}
