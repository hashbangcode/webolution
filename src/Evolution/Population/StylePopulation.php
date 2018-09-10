<?php

namespace Hashbangcode\Webolution\Evolution\Population;

use Hashbangcode\Webolution\Evolution\Individual\Individual;
use Hashbangcode\Webolution\Evolution\Individual\StyleIndividual;
use Hashbangcode\Webolution\Type\Style\Style;

/**
 * Class StylePopulation.
 *
 * @package Hashbangcode\Webolution\Evolution\Population
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
