<?php

namespace Hashbangcode\Webolution\Type\Number\Decorator;

use Hashbangcode\Webolution\IndividualDecorator;

/**
 * Class NumberIndividualDecoratorCli.
 *
 * @package Hashbangcode\Webolution\Type\Number\Decorator
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
