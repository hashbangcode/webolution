<?php

namespace Hashbangcode\Webolution\Type\Image\Decorator;

use Hashbangcode\Webolution\PopulationDecorator;

/**
 * Class ImagePopulationDecoratorHtml.
 *
 * @package Hashbangcode\Webolution\Type\Image\Decorator
 */
class ImagePopulationDecoratorHtml extends PopulationDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->getPopulation()->getIndividuals() as $individual) {
            $individualDecorator = new ImageIndividualDecoratorHtml($individual);
            $output .= $individualDecorator->render();
        }

        return $output;
    }
}
