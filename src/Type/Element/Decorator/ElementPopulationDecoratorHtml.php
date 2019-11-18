<?php

namespace Hashbangcode\Webolution\Type\Element\Decorator;

use Hashbangcode\Webolution\PopulationDecorator;

/**
 * Class ElementPopulationDecoratorHtml.
 *
 * @package Hashbangcode\Webolution\Population\Decorators
 */
class ElementPopulationDecoratorHtml extends PopulationDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->getPopulation()->getIndividuals() as $individual) {
            $individualDecorator = new ElementIndividualDecoratorHtml($individual);
            $output .= $individualDecorator->render();
        }

        return $output;
    }
}
