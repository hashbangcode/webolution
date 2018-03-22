<?php

namespace Hashbangcode\Wevolution\Evolution\Individual\Decorators;

/**
 * Interface StatisticsDecoratorInterface.
 *
 * @package Hashbangcode\Wevolution\Evolution\Statistics\Decorators
 */
class ColorIndividualDecoratorHtml extends IndividualDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return '<span style="background-color:#' . $this->getIndividual()->getObject()->render() . '"> </span>';
    }
}
