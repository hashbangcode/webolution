<?php

namespace Hashbangcode\Wevolution\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\NumberIndividualDecoratorHtml;

/**
 * Class NumberPopulationDecoratorHtml.
 *
 * @package Hashbangcode\Wevolution\Evolution\Population\Decorators
 */
class NumberPopulationDecoratorHtml extends PopulationDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->getPopulation()->getIndividuals() as $individual) {
            $colorIndividualDecoratorCli = new NumberIndividualDecoratorHtml($individual);
            $output .= $colorIndividualDecoratorCli->render();
        }

        return $output;
    }
}
