<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Statistics\Decorators;

use Hashbangcode\Wevolution\Evolution\Statistics\Decorators\StatisticsDecoratorHtml;
use Prophecy\Prophet;

class StatisticsDecoratorHtmlTest extends \PHPUnit_Framework_TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testStatisticsObjectCreation()
    {
        $statistics = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Statistics\Statistics');
        $statisticsDecorator = new StatisticsDecoratorHtml($statistics->reveal());
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Statistics\Decorators\StatisticsDecoratorHtml', $statisticsDecorator);
    }

    public function testRender()
    {
        $statistics = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Statistics\Statistics');
        $statistics->getMinFitness()->willReturn(1);
        $statistics->getMaxFitness()->willReturn(2);
        $statistics->getMeanFitness()->willReturn(3);

        $statisticsDecorator = new StatisticsDecoratorHtml($statistics->reveal());
        $render = $statisticsDecorator->render();
        $this->assertContains('<li><strong>Min Fitness:</strong> 1</li>', $render);
        $this->assertContains('<li><strong>Max Fitness:</strong> 2</li>', $render);
        $this->assertContains('<li><strong>Mean Fitness:</strong> 3</li>', $render);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
