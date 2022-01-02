<?php

namespace Hashbangcode\Webolution\Type\Number\Decorator;

use Hashbangcode\Webolution\IndividualDecorator;

/**
 * Class NumberIndividualDecoratorHtml.
 *
 * @package Hashbangcode\Webolution\Type\Number\Decorator
 */
class NumberIndividualDecoratorHtml extends IndividualDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->getIndividual()->getObject()->getNumber();
    }
}
