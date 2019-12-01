<?php

namespace Hashbangcode\Webolution\Type\Element\Decorator;

use Hashbangcode\Webolution\PopulationDecorator;

/**
 * Class ElementPopulationDecoratorCli.
 *
 * @package Hashbangcode\Webolution\Type\Element\Decorator
 */
class ElementPopulationDecoratorCli extends PopulationDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->getPopulation()->getIndividuals() as $individual) {
            $individualDecorator = new ElementIndividualDecoratorCli($individual);
            $output .= $individualDecorator->render();
        }

        return $output;
    }
}
