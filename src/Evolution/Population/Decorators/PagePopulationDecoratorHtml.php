<?php

namespace Hashbangcode\Wevolution\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\PageIndividualDecoratorHtml;

/**
 * Class NumberPopulationDecoratorHtml.
 *
 * @package Hashbangcode\Wevolution\Evolution\Population\Decorators
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
