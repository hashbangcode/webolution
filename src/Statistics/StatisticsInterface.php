<?php

namespace Hashbangcode\Webolution\Statistics;

use Hashbangcode\Webolution\PopulationInterface;

/**
 * Interface Statistics.
 *
 * @package Hashbangcode\Webolution\Statistics
 */
interface StatisticsInterface
{
    /**
     * Get the median fitness.
     *
     * @return float
     *   The median fitness.
     */
    public function getMedianFitness(): float;

    /**
     * Set the median fitness.
     *
     * @param float $medianFitness
     *   The median fitness.
     */
    public function setMedianFitness(float $medianFitness);

    /**
     * Get the median fitness individual.
     *
     * @return \Hashbangcode\Webolution\Individual|null
     *   The median fitness individual.
     */
    public function getMedianFitnessIndividual();

    /**
     * Set the median fitness individual.
     *
     * @param \Hashbangcode\Webolution\Individual|null $medianFitnessIndividual
     *   The median fitness individual.
     */
    public function setMedianFitnessIndividual($medianFitnessIndividual);

    /**
     * Get min fitness.
     *
     * @return float
     *   The min fitness.
     */
    public function getMinFitness(): float;

    /**
     * Set the min fitness.
     *
     * @param float $minFitness
     *   The min fitness.
     */
    public function setMinFitness(float $minFitness);

    /**
     * Get the max fitness.
     *
     * @return float
     *   The max fitness.
     */
    public function getMaxFitness(): float;

    /**
     * Set the max fitness.
     *
     * @param float $maxFitness
     *   The max fitness to set.
     */
    public function setMaxFitness(float $maxFitness);

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
     * @return float
     *   The mean fitness.
     */
    public function getMeanFitness(): float;

    /**
     * Set the mean fitness.
     *
     * @param float $meanFitness
     *   The mean fitness.
     */
    public function setMeanFitness(float $meanFitness);

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
     * @return \Hashbangcode\Webolution\Individual|null
     *   The max fitness individual.
     */
    public function getMaxFitnessIndividual();

    /**
     * Set the max fitness individual.
     *
     * @param \Hashbangcode\Webolution\Individual|null $maxFitnessIndividual
     *   The max fitness individual.
     */
    public function setMaxFitnessIndividual($maxFitnessIndividual);

    /**
     * Get the min fitness individual.
     *
     * @return \Hashbangcode\Webolution\Individual|null
     *    The min fitness individual.
     */
    public function getMinFitnessIndividual();

    /**
     * Set the min fitness individual.
     *
     * @param \Hashbangcode\Webolution\Individual|null $minFitnessIndividual
     *    The min fitness individual.
     */
    public function setMinFitnessIndividual($minFitnessIndividual);
}
