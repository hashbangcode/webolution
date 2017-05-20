<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;
use Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual;
use Hashbangcode\Wevolution\Type\Style\Style;

/**
 * Class StylePopulation.
 *
 * @package Hashbangcode\Wevolution\Evolution\Population
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
