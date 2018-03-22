<?php

namespace Hashbangcode\Wevolution\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Evolution\Population\PopulationInterface;

/**
 * Interface PopulationDecoratorInterface.
 *
 * @package Hashbangcode\Wevolution\Evolution\Population\Decorators
 */
interface PopulationDecoratorInterface
{

    /**
     * PopulationDecoratorInterface constructor.
     *
     * @param PopulationInterface $population
     *   The population to wrap.
     */
    public function __construct(PopulationInterface $population);

    /**
     * Render the population object.
     *
     * @return mixed
     *   The rendered output.
     */
    public function render();
}
