<?php

namespace Hashbangcode\Webolution;

/**
 * Interface IndividualDecoratorInterface.
 *
 * @package Hashbangcode\Webolution\Evolution\Individual\Decorators
 */
interface IndividualDecoratorInterface
{

    /**
     * IndividualDecoratorInterface constructor.
     *
     * @param IndividualInterface $individual
     *   The individual to wrap.
     */
    public function __construct(IndividualInterface $individual);

    /**
     * Render the individual object.
     *
     * @return mixed
     *   The rendered output.
     */
    public function render();
}
