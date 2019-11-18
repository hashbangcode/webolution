<?php

namespace Hashbangcode\Webolution\Type\Text\Decorator;

use Hashbangcode\Webolution\IndividualDecorator;

/**
 * Class TextIndividualDecoratorCli.
 *
 * @package Hashbangcode\Webolution\Individual\Decorators
 */
class TextIndividualDecoratorCli extends IndividualDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->getIndividual()->getObject()->getText() . PHP_EOL;
    }
}
