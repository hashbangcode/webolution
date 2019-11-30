<?php

namespace Hashbangcode\Webolution\Type\Page\Decorator;

use Hashbangcode\Webolution\Type\Page\Decorator\PageIndividualDecoratorIframe;

/**
 * Class NumberPopulationDecoratorHtml.
 *
 * @package Hashbangcode\Webolution\Type\Page\Decorator
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
            $output .= $individualDecorator->render() . PHP_EOL . PHP_EOL;
        }

        return $output;
    }
}
