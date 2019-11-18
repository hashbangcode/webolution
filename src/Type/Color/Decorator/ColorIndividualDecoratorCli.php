<?php

namespace Hashbangcode\Webolution\Type\Color\Decorator;

use Hashbangcode\Webolution\IndividualDecorator;

/**
 * Class ColorIndividualDecoratorCli.
 *
 * @package Hashbangcode\Webolution\Individual\Decorators
 */
class ColorIndividualDecoratorCli extends IndividualDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->getIndividual()->getObject()->getHex() . PHP_EOL;
    }
}
