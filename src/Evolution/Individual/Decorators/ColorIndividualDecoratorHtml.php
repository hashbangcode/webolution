<?php

namespace Hashbangcode\Webolution\Evolution\Individual\Decorators;

/**
 * Class ColorIndividualDecoratorHtml.
 *
 * @package Hashbangcode\Webolution\Evolution\Individual\Decorators
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
