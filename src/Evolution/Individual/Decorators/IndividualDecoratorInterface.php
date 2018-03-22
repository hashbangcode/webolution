<?php

namespace Hashbangcode\Wevolution\Evolution\Individual\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\IndividualInterface;

/**
 * Interface StatisticsDecoratorInterface.
 *
 * @package Hashbangcode\Wevolution\Evolution\Statistics\Decorators
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
