<?php

namespace Hashbangcode\Webolution\Evolution\Population;

use Hashbangcode\Webolution\Evolution\Individual\Individual;
use Hashbangcode\Webolution\Evolution\Individual\NumberIndividual;

/**
 * Class NumberPopulation.
 *
 * @package Hashbangcode\Webolution\Evolution\Population
 */
class NumberPopulation extends Population
{
    /**
     * Add an individual.
     *
     * @param \Hashbangcode\Webolution\Evolution\Individual\Individual|null $individual
     *   The individual.
     *
     * @return $this
     *
     * @throws \Hashbangcode\Webolution\Type\Number\Exception\InvalidNumberException
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
        uasort($this->individuals, function ($a, $b) {
            $aValue = $a->getFitness();
            $bValue = $b->getFitness();

            if ($aValue == $bValue) {
                return 0;
            }

            return ($aValue < $bValue) ? -1 : 1;
        });

        return $this;
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
