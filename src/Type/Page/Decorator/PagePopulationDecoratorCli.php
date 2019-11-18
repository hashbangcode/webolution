<?php

namespace Hashbangcode\Webolution\Type\Page\Decorator;

use Hashbangcode\Webolution\Type\Page\Decorator\PageIndividualDecoratorCli;
use Hashbangcode\Webolution\PopulationDecorator;

/**
 * Class NumberPopulationDecoratorCli.
 *
 * @package Hashbangcode\Webolution\Population\Decorators
 */
class PagePopulationDecoratorCli extends PopulationDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->getPopulation()->getIndividuals() as $individual) {
            $individualDecorator = new PageIndividualDecoratorCli($individual);
            $output .= $individualDecorator->render() . PHP_EOL;
        }

        return $output;
    }
}
