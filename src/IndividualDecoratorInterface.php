<?php

namespace Hashbangcode\Webolution;

/**
 * Interface IndividualDecoratorInterface.
 *
 * @package Hashbangcode\Webolution
 */
interface IndividualDecoratorInterface
{

    /**
     * IndividualDecoratorInterface constructor.
     *
     * @param \Hashbangcode\Webolution\IndividualInterface $individual
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
