<?php

namespace Hashbangcode\Wevolution\Evolution\Individual\Decorators;

/**
 * Class NumberIndividualDecoratorHtml.
 *
 * @package Hashbangcode\Wevolution\Evolution\Individual\Decorators
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
