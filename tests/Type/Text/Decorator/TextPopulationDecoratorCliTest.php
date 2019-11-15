<?php

namespace Hashbangcode\Webolution\Test\Type\Text\Decorator;

use Hashbangcode\Webolution\Type\Text\Decorator\TextPopulationDecoratorCli;
use Prophecy\Prophet;

class TextPopulationDecoratorCliTest extends TextPopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Text\TextPopulation');
        $numberPopulationDecorator = new TextPopulationDecoratorCli($numberPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Text\Decorator\TextPopulationDecoratorCli', $numberPopulationDecorator);
    }

    public function testRender()
    {
        $numberPopulationDecorator = new TextPopulationDecoratorCli($this->textPopulation->reveal());
        $render = $numberPopulationDecorator->render();
        $this->assertEquals('abc' . PHP_EOL . 'def' . PHP_EOL . 'ghi' . PHP_EOL, $render);
    }
}
