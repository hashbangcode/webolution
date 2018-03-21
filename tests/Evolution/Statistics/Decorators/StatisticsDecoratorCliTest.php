<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Statistics\Decorators;

use Hashbangcode\Wevolution\Evolution\Statistics\Decorators\StatisticsDecoratorCli;
use Prophecy\Prophet;

class StatisticsDecoratorCliTest extends \PHPUnit_Framework_TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testStatisticsObjectCreation()
    {
        $statistics = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Statistics\Statistics');
        $statisticsDecorator = new StatisticsDecoratorCli($statistics->reveal());
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Statistics\Decorators\StatisticsDecoratorCli', $statisticsDecorator);
    }

    public function testRender()
    {
        $statistics = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Statistics\Statistics');
        $statistics->getMinFitness()->willReturn(1);
        $statistics->getMaxFitness()->willReturn(2);
        $statistics->getMeanFitness()->willReturn(3);

        $statisticsDecorator = new StatisticsDecoratorCli($statistics->reveal());
        $render = $statisticsDecorator->render();
        $this->assertContains('Min Fitness: 1', $render);
        $this->assertContains('Max Fitness: 2', $render);
        $this->assertContains('Mean Fitness: 3', $render);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
