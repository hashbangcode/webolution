<?php

namespace Hashbangcode\Wevolution\Evolution\Statistics\Decorators;

use Hashbangcode\Wevolution\Evolution\Statistics\Statistics;

/**
 * Class StatisticsDecorator.
 *
 * @package Hashbangcode\Wevolution\Evolution\Statistics\Decorators
 */
abstract class StatisticsDecorator implements StatisticsDecoratorInterface
{
    /**
     * The Statistics object.
     *
     * @var \Hashbangcode\Wevolution\Evolution\Statistics\Statistics
     */
    protected $statistics;

    /**
     * {@inheritdoc}
     */
    public function __construct(Statistics $statistics)
    {
        $this->statistics = $statistics;
    }
}
