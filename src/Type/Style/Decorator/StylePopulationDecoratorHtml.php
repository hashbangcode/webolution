<?php

namespace Hashbangcode\Webolution\Type\Style\Decorator;

use Hashbangcode\Webolution\PopulationDecorator;

/**
 * Class StylePopulationDecoratorHtml.
 *
 * @package Hashbangcode\Webolution\Evolution\Population\Decorators
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
