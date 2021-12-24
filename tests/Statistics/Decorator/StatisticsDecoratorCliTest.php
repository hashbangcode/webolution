<?php

namespace Hashbangcode\Webolution\Test\Statistics\Decorator;

use Hashbangcode\Webolution\Statistics\Decorator\StatisticsDecoratorCli;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class StatisticsDecoratorCliTest extends TestCase
{

    private $prophet;

    public function setup(): void
    {
        $this->prophet = new Prophet();
    }

    public function testStatisticsObjectCreation()
    {
        $statistics = $this->prophet->prophesize('Hashbangcode\Webolution\Statistics\Statistics');
        $statisticsDecorator = new StatisticsDecoratorCli($statistics->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Statistics\Decorator\StatisticsDecoratorCli', $statisticsDecorator);
    }

    public function testRender()
    {
        $statistics = $this->prophet->prophesize('Hashbangcode\Webolution\Statistics\Statistics');
        $statistics->getMinFitness()->willReturn(1);
        $statistics->getMaxFitness()->willReturn(2);
        $statistics->getMeanFitness()->willReturn(3);

        $statisticsDecorator = new StatisticsDecoratorCli($statistics->reveal());
        $render = $statisticsDecorator->render();
        $this->assertStringContainsString('Min Fitness: 1', $render);
        $this->assertStringContainsString('Max Fitness: 2', $render);
        $this->assertStringContainsString('Mean Fitness: 3', $render);
    }

    protected function tearDown(): void
    {
        $this->prophet->checkPredictions();
    }
}
