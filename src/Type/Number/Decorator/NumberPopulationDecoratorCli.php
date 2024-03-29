<?php

namespace Hashbangcode\Webolution\Type\Number\Decorator;

use Hashbangcode\Webolution\PopulationDecorator;


/**
 * Class NumberPopulationDecoratorCli.
 *
 * @package Hashbangcode\Webolution\Type\Number\Decorator
 */
class NumberPopulationDecoratorCli extends PopulationDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $numbers = [];

        foreach ($this->getPopulation()->getIndividuals() as $individual) {
            $individualDecorator = new NumberIndividualDecoratorCli($individual);
            $numbers[] = $individualDecorator->render();
        }

        return implode(', ', $numbers);
    }
}
