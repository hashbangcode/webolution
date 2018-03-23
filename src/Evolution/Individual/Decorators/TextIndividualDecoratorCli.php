<?php

namespace Hashbangcode\Wevolution\Evolution\Individual\Decorators;

/**
 * Class TextIndividualDecoratorCli.
 *
 * @package Hashbangcode\Wevolution\Evolution\Individual\Decorators
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
