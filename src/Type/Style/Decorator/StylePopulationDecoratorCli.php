<?php

namespace Hashbangcode\Webolution\Type\Style\Decorator;

use Hashbangcode\Webolution\PopulationDecorator;
use Hashbangcode\Webolution\Type\Style\Decorator\StyleIndividualDecoratorCli;

/**
 * Class StylePopulationDecoratorCli.
 *
 * @package Hashbangcode\Webolution\Type\Style\Decorator
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
