<?php

namespace Hashbangcode\Webolution\Evolution\Population;

use Hashbangcode\Webolution\Evolution\Individual\Individual;

interface PopulationInterface
{
    /**
     * Add an individual to the population.
     *
     * @param \Hashbangcode\Webolution\Evolution\Individual\Individual|null $individual
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
    public function getLength();

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
     * Render the population.
     *
     * @return string
     */
    public function render();

    /**
     * Perform a crossover function on certain members of the population.
     */
    public function crossover();
}
