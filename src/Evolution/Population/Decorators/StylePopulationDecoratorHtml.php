<?php

namespace Hashbangcode\Wevolution\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\StyleIndividualDecoratorHtml;

/**
 * Class NumberPopulationDecoratorHtml.
 *
 * @package Hashbangcode\Wevolution\Evolution\Population\Decorators
 */
class StylePopulationDecoratorHtml extends PopulationDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->getPopulation()->getIndividuals() as $individual) {
            $individualDecorator = new StyleIndividualDecoratorHtml($individual);
            $output .= $individualDecorator->render();
        }

        return $output;
    }
}
