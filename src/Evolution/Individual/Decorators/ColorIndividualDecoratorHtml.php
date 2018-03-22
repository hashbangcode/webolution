<?php

namespace Hashbangcode\Wevolution\Evolution\Individual\Decorators;

/**
 * Class ColorIndividualDecoratorHtml.
 *
 * @package Hashbangcode\Wevolution\Evolution\Individual\Decorators
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
