<?php

namespace Hashbangcode\Wevolution\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\NumberIndividualDecoratorCli;

/**
 * Class NumberPopulationDecoratorCli.
 *
 * @package Hashbangcode\Wevolution\Evolution\Population\Decorators
 */
class NumberPopulationDecoratorCli extends PopulationDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->getPopulation()->getIndividuals() as $individual) {
            $numberIndividualDecoratorCli = new NumberIndividualDecoratorCli($individual);
            $output .= $numberIndividualDecoratorCli->render();
        }

        return $output;
    }
}
