<?php

namespace Hashbangcode\Webolution\Test\Evolution\Population\Decorators;

use Hashbangcode\Webolution\Test\Evolution\Population\Decorators\TextPopulationDecoratorTestBase;
use Hashbangcode\Webolution\Evolution\Population\Decorators\TextPopulationDecoratorCli;
use Prophecy\Prophet;

class TextPopulationDecoratorCliTest extends TextPopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Population\TextPopulation');
        $numberPopulationDecorator = new TextPopulationDecoratorCli($numberPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Evolution\Population\Decorators\TextPopulationDecoratorCli', $numberPopulationDecorator);
    }

    public function testRender()
    {
        $numberPopulationDecorator = new TextPopulationDecoratorCli($this->textPopulation->reveal());
        $render = $numberPopulationDecorator->render();
        $this->assertEquals('abc' . PHP_EOL . 'def' . PHP_EOL . 'ghi' . PHP_EOL, $render);
    }
}
