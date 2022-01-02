<?php

namespace Hashbangcode\Webolution\Type\Number\Decorator;

use Hashbangcode\Webolution\PopulationDecorator;

/**
 * Class NumberPopulationDecoratorHtml.
 *
 * @package Hashbangcode\Webolution\Type\Number\Decorator
 */
class NumberPopulationDecoratorHtml extends NumberPopulationDecoratorCli
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
