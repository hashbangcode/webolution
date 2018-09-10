<?php

namespace Hashbangcode\Webolution\Evolution\Population;

use Hashbangcode\Webolution\Evolution\Individual\Individual;
use Hashbangcode\Webolution\Evolution\Individual\ElementIndividual;
use Hashbangcode\Webolution\Type\Element\Element;

/**
 * Class ElementPopulation.
 *
 * @package Hashbangcode\Webolution\Evolution\Population
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
