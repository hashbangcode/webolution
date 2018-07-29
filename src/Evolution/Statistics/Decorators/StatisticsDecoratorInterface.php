<?php

namespace Hashbangcode\Webolution\Evolution\Statistics\Decorators;

use Hashbangcode\Webolution\Evolution\Statistics\StatisticsInterface;

/**
 * Interface StatisticsDecoratorInterface.
 *
 * @package Hashbangcode\Webolution\Evolution\Statistics\Decorators
 */
interface StatisticsDecoratorInterface
{

    /**
     * StatisticsDecoratorInterface constructor.
     *
     * @param StatisticsInterface $statistics
     *   The statistics to wrap.
     */
    public function __construct(StatisticsInterface $statistics);

    /**
     * Render the statistics object.
     *
     * @return mixed
     *   The rendered output.
     */
    public function render();
}
