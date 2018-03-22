<?php

namespace Hashbangcode\Wevolution\Evolution\Statistics\Decorators;

use Hashbangcode\Wevolution\Evolution\Statistics\StatisticsInterface;

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
    public function __construct(StatisticsInterface $statistics)
    {
        $this->statistics = $statistics;
    }
}
