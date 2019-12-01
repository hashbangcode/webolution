<?php

namespace Hashbangcode\Webolution\Statistics\Decorator;

/**
 * Class StatisticsDecorator.
 *
 * @package Hashbangcode\Webolution\Statistics\Decorator
 */
class StatisticsDecoratorCli extends StatisticsDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        $output .= 'Min Fitness: ' . $this->statistics->getMinFitness() . PHP_EOL;
        $output .= 'Max Fitness: ' . $this->statistics->getMaxFitness() . PHP_EOL;
        $output .= 'Mean Fitness: ' . $this->statistics->getMeanFitness() . PHP_EOL;

        return $output;
    }
}
