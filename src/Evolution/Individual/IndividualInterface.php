<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;


interface IndividualInterface
{

    /**
     * Get the underlying type object.
     *
     * @return object
     *   The type object.
     */
    public function getObject();

    /**
     * Mutate the individual.
     *
     * @param int $mutationFactor
     *   The mutation factor.
     * @param int $mutationAmount
     *   The mutation amount.
     */
    public function mutate($mutationFactor = 0, $mutationAmount = 1);

    /**
     * Get the fitness.
     *
     * @return int
     *   The fitness of the individual.
     */
    public function getFitness();

    /**
     * Render the individual.
     *
     * @param string $renderType
     *   The type of render to perform.
     *
     * @return string
     *   The rendered individual.
     */
    public function render($renderType);
}