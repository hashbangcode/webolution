<?php

namespace Hashbangcode\Webolution\Type\Unit;

use Hashbangcode\Webolution\Population;
use Hashbangcode\Webolution\Individual;
use Hashbangcode\Webolution\Type\Image\ImageFactory;

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
        if ($this->getIndividualCount() == 0) {
            return;
        }

        if ($this->getIndividualCount() == 1) {
            // Add a clone of a individual individual.
            $randomIndividual = $this->getRandomIndividual();
            $this->addIndividual(clone $randomIndividual);
            return;
        }

        // Get two individuals from the population.
        $individuals = $this->getRandomIndividuals(2);

        $unit = $individuals[0]->getObject()->getUnit();

        if ($unit == 'auto') {
            // If the unit is 'auto' then there will be no number so we can only clone the current object.
            $randomIndividual = $this->getRandomIndividual();
            $this->addIndividual(clone $randomIndividual);
            return;
        }

        $number = $individuals[1]->getObject()->getNumber();

        // Create a new individual using the combined unit and number and add to the population.
        $this->addIndividual(UnitIndividual::generateFromUnitArguments($number, $unit));
    }
}
