<?php

namespace Hashbangcode\Webolution\Test\Statistics\Decorator;

use Hashbangcode\Webolution\Statistics\Decorator\StatisticsDecoratorHtml;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class StatisticsDecoratorHtmlTest extends TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testStatisticsObjectCreation()
    {
        $statistics = $this->prophet->prophesize('Hashbangcode\Webolution\Statistics\Statistics');
        $statisticsDecorator = new StatisticsDecoratorHtml($statistics->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Statistics\Decorator\StatisticsDecoratorHtml', $statisticsDecorator);
    }

    public function testRender()
    {
        $statistics = $this->prophet->prophesize('Hashbangcode\Webolution\Statistics\Statistics');
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
