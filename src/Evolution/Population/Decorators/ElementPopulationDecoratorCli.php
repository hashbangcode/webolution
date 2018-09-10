<?php

namespace Hashbangcode\Webolution\Evolution\Population\Decorators;

use Hashbangcode\Webolution\Evolution\Individual\Decorators\ElementIndividualDecoratorCli;

/**
 * Class ElementPopulationDecoratorCli.
 *
 * @package Hashbangcode\Webolution\Evolution\Population\Decorators
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
