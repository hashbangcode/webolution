<?php

namespace Hashbangcode\Webolution\Type\Number\Decorator;

use Hashbangcode\Webolution\IndividualDecorator;

/**
 * Class NumberIndividualDecoratorCli.
 *
 * @package Hashbangcode\Webolution\Individual\Decorators
 */
class NumberIndividualDecoratorCli extends IndividualDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->getIndividual()->getObject()->getNumber() . PHP_EOL;
    }
}
