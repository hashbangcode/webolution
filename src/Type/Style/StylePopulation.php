<?php

namespace Hashbangcode\Webolution\Type\Style;

use Hashbangcode\Webolution\Population;
use Hashbangcode\Webolution\Individual;

/**
 * Class StylePopulation.
 *
 * @package Hashbangcode\Webolution\Population
 */
class StylePopulation extends Population
{
    /**
     * {@inheritdoc}
     */
    public function sort()
    {
        // Don't sort style elements.
    }

    /**
     * {@inheritdoc}
     */
    public function addIndividual(Individual $individual = null)
    {
        if (is_null($individual)) {
            $individual = new StyleIndividual(new Style());
        }
        $this->individuals[] = $individual;
    }

    /**
     * {@inheritdoc}
     */
    public function crossover()
    {
        // @todo implement this.
    }
}
