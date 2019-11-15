<?php

namespace Hashbangcode\Webolution\Statistics\Decorator;

use Hashbangcode\Webolution\Statistics\StatisticsInterface;

/**
 * Class StatisticsDecorator.
 *
 * @package Hashbangcode\Webolution\Evolution\Statistics\Decorators
 */
abstract class StatisticsDecorator implements StatisticsDecoratorInterface
{
    /**
     * The Statistics object.
     *
     * @var \Hashbangcode\Webolution\Evolution\Statistics\StatisticsInterface
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
