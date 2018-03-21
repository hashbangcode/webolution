<?php

namespace Hashbangcode\Wevolution\Evolution\Statistics;

use Hashbangcode\Wevolution\Evolution\Population\PopulationInterface;

/**
 * Interface Statistics.
 *
 * @package Hashbangcode\Wevolution\Evolution\Statistics
 */
interface StatisticsInterface
{
    /**
     * Get the median fitness.
     *
     * @return int
     *   The median fitness.
     */
    public function getMedianFitness(): int;

    /**
     * Set the median fitness.
     *
     * @param int $medianFitness
     *   The median fitness.
     */
    public function setMedianFitness(int $medianFitness);

    /**
     * Get the median fitness individual.
     *
     * @return \Hashbangcode\Wevolution\Evolution\Individual\Individual|null
     *   The median fitness individual.
     */
    public function getMedianFitnessIndividual();

    /**
     * Set the median fitness individual.
     *
     * @param \Hashbangcode\Wevolution\Evolution\Individual\Individual|null $medianFitnessIndividual
     *   The median fitness individual.
     */
    public function setMedianFitnessIndividual($medianFitnessIndividual);

    /**
     * Get min fitness.
     *
     * @return int
     *   The min fitness.
     */
    public function getMinFitness(): int;

    /**
     * Set the min fitness.
     *
     * @param int $minFitness
     *   The min fitness.
     */
    public function setMinFitness(int $minFitness);

    /**
     * Get the max fitness.
     *
     * @return int
     *   The max fitness.
     */
    public function getMaxFitness(): int;

    /**
     * Set the max fitness.
     *
     * @param int $maxFitness
     *   The max fitness to set.
     */
    public function setMaxFitness(int $maxFitness);

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
    public function calculateMeanFitness(PopulationInterface $population);

    /**
     * Get the mean fitness.
     *
     * @return int
     *   The mean fitness.
     */
    public function getMeanFitness(): int;

    /**
     * Set the mean fitness.
     *
     * @param int $meanFitness
     *   The mean fitness.
     */
    public function setMeanFitness(int $meanFitness);

    /**
     * Extract the fitness individuals and assign them to min, max and median values.
     *
     * @param PopulationInterface $population
     *   The population.
     *
     * @return $this
     *   The current object.
     */
    public function extractFitnessIndividuals(PopulationInterface $population);

    /**
     * Get the max fitness individual.
     *
     * @return \Hashbangcode\Wevolution\Evolution\Individual\Individual|null
     *   The max fitness individual.
     */
    public function getMaxFitnessIndividual();

    /**
     * Set the max fitness individual.
     *
     * @param \Hashbangcode\Wevolution\Evolution\Individual\Individual|null $maxFitnessIndividual
     *   The max fitness individual.
     */
    public function setMaxFitnessIndividual($maxFitnessIndividual);

    /**
     * Get the min fitness individual.
     *
     * @return \Hashbangcode\Wevolution\Evolution\Individual\Individual|null
     *    The min fitness individual.
     */
    public function getMinFitnessIndividual();

    /**
     * Set the min fitness individual.
     *
     * @param \Hashbangcode\Wevolution\Evolution\Individual\Individual|null $minFitnessIndividual
     *    The min fitness individual.
     */
    public function setMinFitnessIndividual($minFitnessIndividual);
}
