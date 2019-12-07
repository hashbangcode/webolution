<?php

namespace Hashbangcode\Webolution;

use Hashbangcode\Webolution\Type\TypeInterface;

/**
 * Interface IndividualInterface.
 *
 * @package Hashbangcode\Webolution\Individual
 */
interface IndividualInterface
{
    /**
     * Get the name of the individual.
     *
     * @return mixed
     *   The name.
     */
    public function getName(): string;

    /**
     * Get the species of the individual.
     *
     * @return string
     *   The specied name.
     */
    public function getSpecies(): string;

    /**
     * Get the underlying Type object.
     *
     * @return \Hashbangcode\Webolution\Type\TypeInterface
     *   The type object.
     */
    public function getObject(): TypeInterface;

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
     * Get the fitness of the individual.
     *
     * The fitness should be a positive integer.
     *
     * @param string $type
     *   The type of fitness to calculate.
     *
     * @return float
     *   The fitness of the individual.
     */
    public function getFitness($type = ''): float;
}
