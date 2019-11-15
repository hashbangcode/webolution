<?php

namespace Hashbangcode\Webolution\Type\Text\Decorator;

use Hashbangcode\Webolution\PopulationDecorator;

/**
 * Class TextPopulationDecoratorCli.
 *
 * @package Hashbangcode\Webolution\Evolution\Population\Decorators
 */
class TextPopulationDecoratorCli extends PopulationDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->getPopulation()->getIndividuals() as $individual) {
            $individualDecorator = new TextIndividualDecoratorCli($individual);
            $output .= $individualDecorator->render();
        }

        return $output;
    }
}
