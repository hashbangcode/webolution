<?php

namespace Hashbangcode\Wevolution\Evolution\Statistics\Decorators;

use Hashbangcode\Wevolution\Evolution\Statistics\Statistics;

/**
 * Interface StatisticsDecoratorInterface.
 *
 * @package Hashbangcode\Wevolution\Evolution\Statistics\Decorators
 */
interface StatisticsDecoratorInterface
{

    /**
     * StatisticsDecoratorInterface constructor.
     *
     * @param Statistics $statistics
     *   The statistics to wrap.
     */
    public function __construct(Statistics $statistics);

    /**
     * Render the statistics object.
     *
     * @return mixed
     *   The rendered output.
     */
    public function render();
}
