<?php

namespace Hashbangcode\Webolution\Evolution\Individual\Decorators;

/**
 * Class NumberIndividualDecoratorHtml.
 *
 * @package Hashbangcode\Webolution\Evolution\Individual\Decorators
 */
class NumberIndividualDecoratorHtml extends IndividualDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->getIndividual()->getObject()->getNumber() . '<br>';
    }
}
