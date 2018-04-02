<?php

namespace Hashbangcode\Wevolution\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\StyleIndividualDecoratorCli;

/**
 * Class NumberPopulationDecoratorCli.
 *
 * @package Hashbangcode\Wevolution\Evolution\Population\Decorators
 */
class StylePopulationDecoratorCli extends PopulationDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->getPopulation()->getIndividuals() as $individual) {
            $individualDecorator = new StyleIndividualDecoratorCli($individual);
            $output .= $individualDecorator->render();
        }

        return $output;
    }
}
