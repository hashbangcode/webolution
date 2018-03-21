<?php

namespace Hashbangcode\Wevolution\Evolution\Statistics;

use Hashbangcode\Wevolution\Evolution\Population\PopulationInterface;

/**
 * Class Statistics.
 *
 * @package Hashbangcode\Wevolution\Evolution
 */
class Statistics
{
    /**
     * The max fitness.
     *
     * @var int
     */
    protected $maxFitness = 0;

    /**
     * The min fitness.
     *
     * @var int
     */
    protected $minFitness = 0;

    /**
     * The mean fitness.
     *
     * @var int
     */
    protected $meanFitness = 0;

    /**
     * Max fitness individual.
     *
     * @var \Hashbangcode\Wevolution\Evolution\Individual\Individual|null
     */
    protected $maxFitnessIndividual;

    /**
     * @return \Hashbangcode\Wevolution\Evolution\Individual\Individual|null
     */
    public function getMinFitnessIndividual()
    {
        return $this->minFitnessIndividual;
    }

    /**
     * @param \Hashbangcode\Wevolution\Evolution\Individual\Individual|null $minFitnessIndividual
     */
    public function setMinFitnessIndividual($minFitnessIndividual)
    {
        $this->minFitnessIndividual = $minFitnessIndividual;
    }

    /**
     * @return \Hashbangcode\Wevolution\Evolution\Individual\Individual|null
     */
    public function getMedianFitnessIndividual()
    {
        return $this->medianFitnessIndividual;
    }

    /**
     * @param \Hashbangcode\Wevolution\Evolution\Individual\Individual|null $medianFitnessIndividual
     */
    public function setMedianFitnessIndividual($medianFitnessIndividual)
    {
        $this->medianFitnessIndividual = $medianFitnessIndividual;
    }

    /**
     * Min fitness individual.
     *
     * @var \Hashbangcode\Wevolution\Evolution\Individual\Individual|null
     */
    protected $minFitnessIndividual;

    /**
     * @return \Hashbangcode\Wevolution\Evolution\Individual\Individual|null
     */
    public function getMaxFitnessIndividual()
    {
        return $this->maxFitnessIndividual;
    }

    /**
     * @param \Hashbangcode\Wevolution\Evolution\Individual\Individual|null $maxFitnessIndividual
     */
    public function setMaxFitnessIndividual($maxFitnessIndividual)
    {
        $this->maxFitnessIndividual = $maxFitnessIndividual;
    }

    /**
     * Median fitness individual.
     *
     * @var \Hashbangcode\Wevolution\Evolution\Individual\Individual|null
     */
    protected $medianFitnessIndividual;

    /**
     * Get min fitness.
     *
     * @return int
     *   The min fitness.
     */
    public function getMinFitness(): int
    {
        return $this->minFitness;
    }

    /**
     * Set the min fitness.
     *
     * @param int $minFitness
     *   The min fitness.
     */
    public function setMinFitness(int $minFitness)
    {
        $this->minFitness = $minFitness;
    }

    /**
     * Get the mean fitness.
     *
     * @return int
     *   The mean fitness.
     */
    public function getMeanFitness(): int
    {
        return $this->meanFitness;
    }

    /**
     * Set the mean fitness.
     *
     * @param int $meanFitness
     *   The mean fitness.
     */
    public function setMeanFitness(int $meanFitness)
    {
        $this->meanFitness = $meanFitness;
    }

    /**
     * Get the max fitness.
     *
     * @return int
     *   The max fitness.
     */
    public function getMaxFitness(): int
    {
        return $this->maxFitness;
    }

    /**
     * Set the max fitness.
     *
     * @param int $maxFitness
     *   The max fitness to set.
     */
    public function setMaxFitness(int $maxFitness)
    {
        $this->maxFitness = $maxFitness;
    }

    /**
     * Using a population, calculate the mean fitness.
     *
     * The mean fitness is stored in the meanFitness property.
     *
     * @param PopulationInterface $population
     *   The population.
     * @return int
     *   The mean fitness.
     */
    public function calculateMeanFitness(PopulationInterface $population)
    {
        $fitnessSum = 0;
        foreach ($population->getIndividuals() as $individual) {
            $fitnessSum += $individual->getFitness();
        }
        $this->setMeanFitness($fitnessSum / $population->getLength());
        return $this->getMeanFitness();
    }

    /**
     * Extract the fitness individuals and assign them to min, max and median values.
     *
     * @param PopulationInterface $population
     *   The population.
     *
     * @return $this
     *   The current object.
     */
    public function extractFitnessIndividuals(PopulationInterface $population)
    {
        // Sort the current population.
        $population->sort();

        foreach ($population->getIndividuals() as $key => $individual) {
            $fitness = $individual->getFitness();

            // Store Max.
            if (!is_object($this->getMaxFitnessIndividual())
                || $fitness > $this->getMaxFitnessIndividual()->getFitness()) {
                $this->getMaxFitnessIndividual($individual);
            }

            // Store Min.
            if (!is_object($this->minFitnessIndividual())
                || $fitness < $this->getMinFitnessIndividual()->getFitness()) {
                $this->minFitnessIndividual($individual);
            }
        }

        // Get Median.
        $individuals = $this->getIndividuals();
        $slicedArray = array_slice($individuals, floor(count($individuals)/ 2), 1);
        $this->setMedianFitnessIndividual(array_pop($slicedArray));

        return $this;
    }
}
