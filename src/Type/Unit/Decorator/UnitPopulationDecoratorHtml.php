<?php

namespace Hashbangcode\Webolution\Type\Unit\Decorator;

use Hashbangcode\Webolution\PopulationDecorator;

/**
 * Class UnitPopulationDecoratorHtml.
 *
 * @package Hashbangcode\Webolution\Type\Unit\Decorator
 */
class UnitPopulationDecoratorHtml extends PopulationDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->getPopulation()->getIndividuals() as $individual) {
            $individualDecorator = new UnitIndividualDecoratorHtml($individual);
            $output .= $individualDecorator->render();
        }

        return $output;
    }
}
