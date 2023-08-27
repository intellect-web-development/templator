<?php

declare(strict_types=1);

namespace IWD\Templator\Service;

use IWD\Templator\Dto\Renderable;

class Renderer
{
    public function render(Renderable $renderable): string
    {
        $template = $renderable->template;
        foreach ($renderable->variables as $key => $value) {
            if (is_string($value)) {
                $template = str_replace('{{ ' . $key . ' }}', $value, $template);
            }
        }

        return $template;
    }
}
