<?php

namespace Hashbangcode\Webolution;

interface PopulationInterface
{
    /**
     * Add an individual to the population.
     *
     * @param \Hashbangcode\Webolution\Individual|null $individual
     *   An individual. Subclasses may also pass a null value to generate a new
     *   random individual.
     */
    public function addIndividual(Individual $individual = null);

    /**
     * Sort the population.
     */
    public function sort();

    /**
     * Get the current population level.
     *
     * @return int
     *   The number of Individuals in the population.
     */
    public function getIndividualCount();

    /**
     * Get the individuals for this population.
     *
     * @return array
     *   The individual array.
     */
    public function getIndividuals();

    /**
     * Set the individuals in this population.
     *
     * @param array $individuals
     *   The individuals.
     */
    public function setIndividuals($individuals);

    /**
     * Perform a crossover function on certain members of the population.
     */
    public function crossover();
}
