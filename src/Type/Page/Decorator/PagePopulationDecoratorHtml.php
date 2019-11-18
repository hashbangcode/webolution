<?php

namespace Hashbangcode\Webolution\Type\Page\Decorator;

use Hashbangcode\Webolution\PopulationDecorator;
use Hashbangcode\Webolution\Type\Page\Decorator\PageIndividualDecoratorHtml;

/**
 * Class NumberPopulationDecoratorHtml.
 *
 * @package Hashbangcode\Webolution\Type\Page\Decorator
 */
class PagePopulationDecoratorHtml extends PopulationDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->getPopulation()->getIndividuals() as $individual) {
            $individualDecorator = new PageIndividualDecoratorHtml($individual);
            $output .= $individualDecorator->render() . PHP_EOL;
        }

        return $output;
    }
}
