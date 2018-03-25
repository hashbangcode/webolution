<?php

namespace Hashbangcode\Wevolution\Evolution\Individual\Decorators;

/**
 * Class ElementIndividualDecoratorCli.
 *
 * @package Hashbangcode\Wevolution\Evolution\Individual\Decorators
 */
class ElementIndividualDecoratorCli extends IndividualDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->getIndividual()->getObject()->getHex() . PHP_EOL;
    }
}
