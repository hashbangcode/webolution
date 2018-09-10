<?php

namespace Hashbangcode\Webolution\Evolution\Population\Decorators;

use Hashbangcode\Webolution\Evolution\Individual\Decorators\StyleIndividualDecoratorCli;

/**
 * Class StylePopulationDecoratorCli.
 *
 * @package Hashbangcode\Webolution\Evolution\Population\Decorators
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
