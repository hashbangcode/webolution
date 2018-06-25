<?php

namespace Hashbangcode\Wevolution\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\PageIndividualDecoratorIframe;

/**
 * Class NumberPopulationDecoratorHtml.
 *
 * @package Hashbangcode\Wevolution\Evolution\Population\Decorators
 */
class PagePopulationDecoratorIframe extends PagePopulationDecoratorHtml
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->getPopulation()->getIndividuals() as $individual) {
            $individualDecorator = new PageIndividualDecoratorIframe($individual);
            $output .= $individualDecorator->render() . PHP_EOL;
        }

        return $output;
    }
}
