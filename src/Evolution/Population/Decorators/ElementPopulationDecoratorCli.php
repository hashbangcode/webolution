<?php

namespace Hashbangcode\Wevolution\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\ElementIndividualDecoratorCli;

/**
 * Class NumberPopulationDecoratorCli.
 *
 * @package Hashbangcode\Wevolution\Evolution\Population\Decorators
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
