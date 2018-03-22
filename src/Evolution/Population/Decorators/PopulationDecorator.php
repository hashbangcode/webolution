<?php

namespace Hashbangcode\Wevolution\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Evolution\Population\PopulationInterface;

/**
 * Class PopulationDecorator.
 *
 * @package Hashbangcode\Wevolution\Evolution\Population\Decorators
 */
abstract class PopulationDecorator implements PopulationDecoratorInterface
{

    /**
     * The population object.
     *
     * @var \Hashbangcode\Wevolution\Evolution\Population\PopulationInterface
     */
    protected $population;

    /**
     * Get the population.
     *
     * @return PopulationInterface
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
