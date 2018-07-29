<?php

namespace Hashbangcode\Webolution\Evolution\Individual\Decorators;

/**
 * Class ColorIndividualDecoratorCss.
 *
 * @package Hashbangcode\Webolution\Evolution\Individual\Decorators
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
