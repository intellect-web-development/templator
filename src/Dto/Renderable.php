<?php

declare(strict_types=1);

namespace IWD\Templator\Dto;

readonly class Renderable
{
    public function __construct(
        public string $template,
        public array $variables = [],
    ) {
    }
}
