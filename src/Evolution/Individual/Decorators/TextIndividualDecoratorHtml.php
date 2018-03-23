<?php

namespace Hashbangcode\Wevolution\Evolution\Individual\Decorators;

/**
 * Class TextIndividualDecoratorCli.
 *
 * @package Hashbangcode\Wevolution\Evolution\Individual\Decorators
 */
class TextIndividualDecoratorHtml extends IndividualDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->getIndividual()->getObject()->getText() . '<br>' . PHP_EOL;
    }
}
