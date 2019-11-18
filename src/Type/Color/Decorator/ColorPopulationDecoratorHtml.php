<?php

namespace Hashbangcode\Webolution\Type\Color\Decorator;

use Hashbangcode\Webolution\PopulationDecorator;

/**
 * Class ColorPopulationDecoratorHtml.
 *
 * @package Hashbangcode\Webolution\Population\Decorators
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
            $individualDecorator = new ColorIndividualDecoratorHtml($individual);
            $output .= $individualDecorator->render();
        }

        return $output;
    }
}
