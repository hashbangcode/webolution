<?php

namespace Hashbangcode\Wevolution\Evolution\Individual\Decorators;

/**
 * Class NumberIndividualDecoratorCli.
 *
 * @package Hashbangcode\Wevolution\Evolution\Individual\Decorators
 */
class NumberIndividualDecoratorCli extends IndividualDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->getIndividual()->getObject()->getNumber() . PHP_EOL;
    }
}
