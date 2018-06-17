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
        // Get two individuals from the population.
        $individuals = $this->getRandomIndividuals(2);

        // Make sure we have Individuals to use.
        if ($individuals == false) {
            // Add a clone of a individual individual.
            $randomIndividual = $this->getRandomIndividual();
            $this->addIndividual(clone $randomIndividual);

            // Don't do anything else.
            return;
        }

        $number1 = $individuals[0]->getObject()->getNumber();
        $number2 = $individuals[1]->getObject()->getNumber();

        // Create a new number based on the average of the previous numbers..
        $number = round(($number1 + $number2) / 2);

        // Create a new individual.
        $individualNew = NumberIndividual::generateFromNumber((int) $number);

        // Add the individual to the population.
        $this->addIndividual($individualNew);
    }
}
