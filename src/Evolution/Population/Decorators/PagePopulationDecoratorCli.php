<?php

namespace Hashbangcode\Wevolution\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\PageIndividualDecoratorCli;

/**
 * Class NumberPopulationDecoratorCli.
 *
 * @package Hashbangcode\Wevolution\Evolution\Population\Decorators
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
