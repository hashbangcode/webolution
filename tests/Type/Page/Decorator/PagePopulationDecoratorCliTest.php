<?php

namespace Hashbangcode\Webolution\Test\Type\Page\Decorator;

use Hashbangcode\Webolution\Type\Page\Decorator\PagePopulationDecoratorCli;
use Prophecy\Prophet;

class PagePopulationDecoratorCliTest extends PagePopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $population = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Page\PagePopulation');
        $populationDecorator = new PagePopulationDecoratorCli($population->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Page\Decorator\PagePopulationDecoratorCli', $populationDecorator);
    }

    public function testRender()
    {
        $populationDecorator = new PagePopulationDecoratorCli($this->textPopulation->reveal());
        $render = $populationDecorator->render();
        $this->assertStringEqualsFile(__DIR__ . '/data/page01cli.txt', $render);
    }
}
