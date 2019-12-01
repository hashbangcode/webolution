<?php

namespace Hashbangcode\Webolution\Type\Color\Decorator;

use Hashbangcode\Webolution\IndividualDecorator;

/**
 * Class ColorIndividualDecoratorCss.
 *
 * @package Hashbangcode\Webolution\Type\Color\Decorator
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
