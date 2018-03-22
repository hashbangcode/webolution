<?php

namespace Hashbangcode\Wevolution\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\ColorIndividualDecoratorCli;

/**
 * Class ColorPopulationDecoratorCli.
 *
 * @package Hashbangcode\Wevolution\Evolution\Population\Decorators
 */
class ColorPopulationDecoratorCli extends PopulationDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->getPopulation()->getIndividuals() as $individual) {
            $colorIndividualDecoratorCli = new ColorIndividualDecoratorCli($individual);
            $output .= $colorIndividualDecoratorCli->render();
        }

        return $output;
    }
}
