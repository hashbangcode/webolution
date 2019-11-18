<?php

namespace Hashbangcode\Webolution\Statistics\Decorator;

use Hashbangcode\Webolution\Statistics\StatisticsInterface;

/**
 * Interface StatisticsDecoratorInterface.
 *
 * @package Hashbangcode\Webolution\Statistics\Decorators
 */
interface StatisticsDecoratorInterface
{

    /**
     * StatisticsDecoratorInterface constructor.
     *
     * @param \Hashbangcode\Webolution\Statistics\StatisticsInterface $statistics
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
