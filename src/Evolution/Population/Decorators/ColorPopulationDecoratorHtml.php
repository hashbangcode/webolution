<?php

namespace Hashbangcode\Wevolution\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\ColorIndividualDecoratorHtml;

/**
 * Class ColorPopulationDecoratorHtml.
 *
 * @package Hashbangcode\Wevolution\Evolution\Population\Decorators
 */
class ColorPopulationDecoratorHtml extends PopulationDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->getPopulation()->getIndividuals() as $individual) {
            $colorIndividualDecoratorCli = new ColorIndividualDecoratorHtml($individual);
            $output .= $colorIndividualDecoratorCli->render();
        }

        return $output;
    }
}
