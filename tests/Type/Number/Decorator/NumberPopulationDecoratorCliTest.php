<?php

namespace Hashbangcode\Webolution\Test\Type\Number\Decorator;

use Hashbangcode\Webolution\Type\Number\Decorator\NumberPopulationDecoratorCli;
use Prophecy\Prophet;

class NumberPopulationDecoratorCliTest extends NumberPopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Number\NumberPopulation');
        $numberPopulationDecorator = new NumberPopulationDecoratorCli($numberPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Number\Decorator\NumberPopulationDecoratorCli', $numberPopulationDecorator);
    }

    public function testRender()
    {
        $numberPopulationDecorator = new NumberPopulationDecoratorCli($this->numberPopulation->reveal());
        $render = $numberPopulationDecorator->render();
        $this->assertEquals(1 . PHP_EOL . 2 . PHP_EOL . 3 . PHP_EOL, $render);
    }
}
