<?php

namespace Hashbangcode\Webolution\Type\Page;

use Hashbangcode\Webolution\Population;
use Hashbangcode\Webolution\Individual;
use Hashbangcode\Webolution\Type\Element\Element;
use Hashbangcode\Webolution\Type\Style\Style;

/**
 * Class ElementPopulation.
 *
 * @package Hashbangcode\Webolution\Population
 */
class PagePopulation extends Population
{
    /**
     * {@inheritdoc}
     */
    public function sort()
    {
        // Do not sort pages.
    }

    /**
     * Add an individual.
     *
     * @param \Hashbangcode\Webolution\Individual|null $individual
     *   Add an individual.
     *
     * @return $this
     *   The current object.
     */
    public function addIndividual(Individual $individual = null)
    {
        if (is_null($individual)) {
            $individual = PageIndividual::generateBlankPage();

            $element = new Element('div');
            $individual->getObject()->setBody($element);

            $style_object = new Style('div');
            $individual->getObject()->setStyle($style_object);
        }

        $this->individuals[] = $individual;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function crossover()
    {
        // @todo implement this.
    }
}
