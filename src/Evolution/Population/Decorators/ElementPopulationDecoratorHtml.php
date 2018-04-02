<?php

namespace Hashbangcode\Wevolution\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\ElementIndividualDecoratorHtml;

/**
 * Class NumberPopulationDecoratorHtml.
 *
 * @package Hashbangcode\Wevolution\Evolution\Population\Decorators
 */
class ElementPopulationDecoratorHtml extends PopulationDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->getPopulation()->getIndividuals() as $individual) {
            $individualDecorator = new ElementIndividualDecoratorHtml($individual);
            $output .= $individualDecorator->render();
        }

        return $output;
    }
}
