<?php

namespace Hashbangcode\Webolution\Evolution\Population\Decorators;

use Hashbangcode\Webolution\Evolution\Population\PopulationInterface;

/**
 * Interface PopulationDecoratorInterface.
 *
 * @package Hashbangcode\Webolution\Evolution\Population\Decorators
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
