<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;
use Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual;

/**
 * Class NumberPopulation
 * @package Hashbangcode\Wevolution\Evolution\Population
 */
class NumberPopulation extends Population
{
    /**
     * Add an individual.
     *
     * @param \Hashbangcode\Wevolution\Evolution\Individual\Individual|null $individual
     *   The individual.
     *
     * @return self
     */
    public function addIndividual(Individual $individual = null)
    {
        if (is_null($individual)) {
            $number = mt_rand(1, 10);
            $individual = NumberIndividual::generateFromNumber($number);
        }
        $this->individuals[] = $individual;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function sort()
    {
        asort($this->individuals);
    }

    /**
     * {@inheritdoc}
     */
    public function crossover()
    {
        // Get two random individuals.
        // MIX THEM!
        // @todo finish this.
    }
}
