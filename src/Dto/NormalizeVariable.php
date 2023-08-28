<?php

declare(strict_types=1);

namespace IWD\Templator\Dto;

class NormalizeVariable
{
    public readonly string $raw;
    public readonly string $regular;
    public readonly string $targetVariable;
    public readonly array $filters;

    public function __construct(
        string $raw,
    ) {
        $this->raw = $raw;
        $this->regular = trim(str_replace(' ', '', $raw), '{} ');
        $explode = explode('|', $this->regular);
        $this->targetVariable = array_shift($explode);
        $this->filters = $explode;
    }
}
