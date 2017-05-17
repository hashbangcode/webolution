<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;

interface PopulationInterface
{
    /**
     * @param \Hashbangcode\Wevolution\Evolution\Individual\Individual|null $individual
     * @return mixed
     */
    public function addIndividual(Individual $individual = null);

    /**
     * @return mixed
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
     * @return mixed
     */
    public function getIndividuals();

    /**
     * @return mixed
     */
    public function render();

    /**
     * Perform a crossover function on certain members of the population.
     */
    public function crossover();
}
