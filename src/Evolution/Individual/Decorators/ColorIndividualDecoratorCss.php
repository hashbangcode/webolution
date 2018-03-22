<?php

namespace Hashbangcode\Wevolution\Evolution\Individual\Decorators;

/**
 * Class ColorIndividualDecoratorCss.
 *
 * @package Hashbangcode\Wevolution\Evolution\Individual\Decorators
 */
class ColorIndividualDecoratorCss extends IndividualDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return '#' . $this->getIndividual()->getObject()->getHex();
    }
}
