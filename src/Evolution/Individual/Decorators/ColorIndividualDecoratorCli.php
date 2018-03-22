<?php

namespace Hashbangcode\Wevolution\Evolution\Individual\Decorators;

/**
 * Class ColorIndividualDecoratorCli.
 *
 * @package Hashbangcode\Wevolution\Evolution\Individual\Decorators
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
