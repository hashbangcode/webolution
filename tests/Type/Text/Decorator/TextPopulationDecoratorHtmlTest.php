<?php

namespace Hashbangcode\Webolution\Test\Type\Text\Decorator;

use Hashbangcode\Webolution\Type\Text\Decorator\TextPopulationDecoratorHtml;
use Prophecy\Prophet;

class TextPopulationDecoratorHtmlTest extends TextPopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Text\TextPopulation');
        $numberPopulationDecorator = new TextPopulationDecoratorHtml($numberPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Text\Decorator\TextPopulationDecoratorHtml', $numberPopulationDecorator);
    }

    public function testRender()
    {
        $numberPopulationDecorator = new TextPopulationDecoratorHtml($this->textPopulation->reveal());
        $render = $numberPopulationDecorator->render();
        $this->assertEquals('abc' . '<br>' . PHP_EOL . 'def' . '<br>' . PHP_EOL . 'ghi' . '<br>' . PHP_EOL, $render);
    }
}
