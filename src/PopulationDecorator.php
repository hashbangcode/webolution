<?php

namespace Hashbangcode\Webolution;

/**
 * Class PopulationDecorator.
 *
 * @package Hashbangcode\Webolution
 */
abstract class PopulationDecorator implements PopulationDecoratorInterface
{
    /**
     * @var \Hashbangcode\Webolution\PopulationInterface The population object.
     */
    protected $population;

    /**
     * Get the population.
     *
     * @return \Hashbangcode\Webolution\PopulationInterface
     *   The population.
     */
    public function getPopulation(): PopulationInterface
    {
        return $this->population;
    }

    /**
     * {@inheritdoc}
     */
    public function __construct(PopulationInterface $population)
    {
        $this->population = $population;
    }
}
