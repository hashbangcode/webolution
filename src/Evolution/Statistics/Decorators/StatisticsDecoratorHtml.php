<?php

namespace Hashbangcode\Webolution\Evolution\Statistics\Decorators;

/**
 * Class StatisticsDecorator.
 *
 * @package Hashbangcode\Webolution\Evolution\Statistics\Decorators
 */
class StatisticsDecoratorHtml extends StatisticsDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        $output .= '<ul>';
        $output .= '<li><strong>Min Fitness:</strong> ' . $this->statistics->getMinFitness() . '</li>' . PHP_EOL;
        $output .= '<li><strong>Max Fitness:</strong> ' . $this->statistics->getMaxFitness() . '</li>' . PHP_EOL;
        $output .= '<li><strong>Mean Fitness:</strong> ' . $this->statistics->getMeanFitness() . '</li>' . PHP_EOL;
        $output .= '</ul>';

        return $output;
    }
}
