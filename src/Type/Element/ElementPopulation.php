<?php

namespace Hashbangcode\Webolution\Type\Element;

use Hashbangcode\Webolution\Population;
use Hashbangcode\Webolution\Individual;

/**
 * Class ElementPopulation.
 *
 * @package Hashbangcode\Webolution\Population
 */
class ElementPopulation extends Population
{
    /**
     * {@inheritdoc}
     */
    public function sort()
    {
        // Don't sort this type of population.
    }

    /**
     * {@inheritdoc}
     */
    public function addIndividual(Individual $individual = null)
    {
        if (is_null($individual)) {
            $individual = ElementIndividual::generateFromElementType('div');
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
