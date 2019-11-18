<?php

namespace Hashbangcode\Webolution\Type\Text\Decorator;

use Hashbangcode\Webolution\PopulationDecorator;

/**
 * Class TextPopulationDecoratorHtml.
 *
 * @package Hashbangcode\Webolution\Type\Text\Decorator
 */
class TextPopulationDecoratorHtml extends PopulationDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->getPopulation()->getIndividuals() as $individual) {
            $individualDecorator = new TextIndividualDecoratorHtml($individual);
            $output .= $individualDecorator->render();
        }

        return $output;
    }
}
