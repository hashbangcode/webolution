<?php

namespace Hashbangcode\Webolution\Type\Color\Decorator;

use Hashbangcode\Webolution\IndividualDecorator;

/**
 * Class ColorIndividualDecoratorHtml.
 *
 * @package Hashbangcode\Webolution\Type\Color\Decorator
 */
class ColorIndividualDecoratorHtml extends IndividualDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return '<span style="background-color:#' . $this->getIndividual()->getObject()->getHex() . '"> </span>';
    }
}
