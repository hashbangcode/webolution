<?php

namespace Hashbangcode\Webolution\Type\Unit\Decorator;

use Hashbangcode\Webolution\PopulationDecorator;

/**
 * Class UnitPopulationDecoratorCli.
 *
 * @package Hashbangcode\Webolution\Population\Decorators
 */
class UnitPopulationDecoratorCli extends PopulationDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->getPopulation()->getIndividuals() as $individual) {
            $individualDecorator = new UnitIndividualDecoratorCli($individual);
            $output .= $individualDecorator->render();
        }

        return $output;
    }
}
