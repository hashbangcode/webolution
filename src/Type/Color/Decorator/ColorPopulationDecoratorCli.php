<?php

namespace Hashbangcode\Webolution\Type\Color\Decorator;

use Hashbangcode\Webolution\PopulationDecorator;

/**
 * Class ColorPopulationDecoratorCli.
 *
 * @package Hashbangcode\Webolution\Population\Decorators
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
            $individualDecorator = new ColorIndividualDecoratorCli($individual);
            $output .= $individualDecorator->render();
        }

        return $output;
    }
}
