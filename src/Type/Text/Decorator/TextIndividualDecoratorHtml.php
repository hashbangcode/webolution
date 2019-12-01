<?php

namespace Hashbangcode\Webolution\Type\Text\Decorator;

use Hashbangcode\Webolution\IndividualDecorator;

/**
 * Class TextIndividualDecoratorCli.
 *
 * @package Hashbangcode\Webolution\Type\Text\Decorator
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
