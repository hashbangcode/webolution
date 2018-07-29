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
    public function render()
    {
        $output = parent::render();

        return $output;
    }

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
            $style = new Style();

            $individual = new StyleIndividual($style);
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
