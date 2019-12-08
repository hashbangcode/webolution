<?php

namespace Hashbangcode\Webolution\Type\Number;

use Hashbangcode\Webolution\Individual;
use Hashbangcode\Webolution\Population;

/**
 * Class NumberPopulation.
 *
 * @package Hashbangcode\Webolution\Population
 */
class NumberPopulation extends Population
{
    /**
     * Add an individual.
     *
     * @param \Hashbangcode\Webolution\Individual|null $individual
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

        $number1 = $individuals[0]->getObject()->getNumber();
        $number2 = $individuals[1]->getObject()->getNumber();

        // Create a new number based on the average of the previous numbers..
        $number = round(($number1 + $number2) / 2);

        // Create a new individual and add the individual to the population.
        $this->addIndividual(NumberIndividual::generateFromNumber((int) $number));
    }
}
