<?php

namespace Hashbangcode\Wevolution\Evolution\Individual\Decorators;

/**
 * Interface StatisticsDecoratorInterface.
 *
 * @package Hashbangcode\Wevolution\Evolution\Statistics\Decorators
 */
class ColorIndividualDecoratorCli extends IndividualDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->getIndividual()->getObject()->render() . PHP_EOL;
    }
}
