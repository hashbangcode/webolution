<?php

namespace Hashbangcode\Webolution\Test\Evolution\Population\Decorators;

use Hashbangcode\Webolution\Test\Evolution\Population\Decorators\PagePopulationDecoratorTestBase;
use Hashbangcode\Webolution\Evolution\Population\Decorators\PagePopulationDecoratorCli;
use Prophecy\Prophet;

class PagePopulationDecoratorCliTest extends PagePopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $population = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Population\PagePopulation');
        $populationDecorator = new PagePopulationDecoratorCli($population->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Evolution\Population\Decorators\PagePopulationDecoratorCli', $populationDecorator);
    }

    public function testRender()
    {
        $populationDecorator = new PagePopulationDecoratorCli($this->textPopulation->reveal());
        $render = $populationDecorator->render();
        $this->assertStringEqualsFile('tests/Evolution/Population/Decorators/data/page01cli.txt', $render);
    }
}
