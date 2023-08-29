<?php

declare(strict_types=1);

namespace IWD\Templator\Service;

use Adbar\Dot;
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

        $template = $renderable->template;
        foreach ($normalizeVariables as $variable) {
            $variableValue = $this->propertyAccessor->getValue($renderable->variables, "[{$variable->targetVariable}]");
            if (null === $variableValue) {
                $variableValue = $this->propertyAccessor->getValue($renderable->variables, "[{$variable->rootTargetVariable}]");
            }
            if (is_object($variableValue)) {
                $template = str_replace(
                    $variable->raw,
                    (string) $this->propertyAccessor->getValue($variableValue, $variable->withoutRootTargetVariable),
                    $template
                );
            }
            if (is_array($variableValue)) {
                $dotVariableValue = new Dot($variableValue, true);
                $template = str_replace(
                    $variable->raw,
                    (string) $dotVariableValue[$variable->withoutRootTargetVariable],
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
