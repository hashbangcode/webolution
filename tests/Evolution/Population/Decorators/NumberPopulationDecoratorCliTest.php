<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Test\Evolution\Population\Decorators\NumberPopulationDecoratorTestBase;
use Hashbangcode\Wevolution\Evolution\Population\Decorators\NumberPopulationDecoratorCli;
use Prophecy\Prophet;

class NumberPopulationDecoratorCliTest extends NumberPopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Population\NumberPopulation');
        $numberPopulationDecorator = new NumberPopulationDecoratorCli($numberPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Population\Decorators\NumberPopulationDecoratorCli', $numberPopulationDecorator);
    }

    public function testRender()
    {
        $numberPopulationDecorator = new NumberPopulationDecoratorCli($this->numberPopulation->reveal());
        $render = $numberPopulationDecorator->render();
        $this->assertEquals(1 . PHP_EOL . 2 . PHP_EOL . 3 . PHP_EOL, $render);
    }
}
