<?php

namespace Hashbangcode\Webolution\Evolution\Population\Decorators;

use Hashbangcode\Webolution\Evolution\Individual\Decorators\StyleIndividualDecoratorHtml;

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
