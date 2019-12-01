<?php

namespace Hashbangcode\Webolution\Type\Unit;

use Hashbangcode\Webolution\Population;
use Hashbangcode\Webolution\Individual;

/**
 * Class UnitPopulation.
 *
 * @package Hashbangcode\Webolution\Population
 */
class UnitPopulation extends Population
{
    /**
     * Add an individual.
     *
     * @param Individual|null $individual
     *   The Individual to add (optional).
     *
     * @return $this
     *   The current object.
     */
    public function addIndividual(Individual $individual = null)
    {
        if (is_null($individual)) {
            $individual = UnitIndividual::generateRandomUnit();
        }
        $this->individuals[] = $individual;

        return $this;
    }

    /**
     * Sort the population.
     *
     * @return $this
     *   The current object.
     */
    public function sort($direction = 'ASC')
    {
        uasort($this->individuals, function ($a, $b) use ($direction) {

            $aValue = $a->getFitness($this->getPopulationFitnessType());
            $bValue = $b->getFitness($this->getPopulationFitnessType());

            if ($aValue == $bValue) {
                return 0;
            }

            if ($direction == 'ASC') {
                return ($aValue < $bValue) ? -1 : 1;
            } else {
                return ($aValue > $bValue) ? -1 : 1;
            }
        });

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function crossover()
    {
    }
}
