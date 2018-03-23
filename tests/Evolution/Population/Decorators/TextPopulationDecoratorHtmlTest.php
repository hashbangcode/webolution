<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Test\Evolution\Population\Decorators\TextPopulationDecoratorTestBase;
use Hashbangcode\Wevolution\Evolution\Population\Decorators\TextPopulationDecoratorHtml;
use Prophecy\Prophet;

class TextPopulationDecoratorHtmlTest extends TextPopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Population\TextPopulation');
        $numberPopulationDecorator = new TextPopulationDecoratorHtml($numberPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Population\Decorators\TextPopulationDecoratorHtml', $numberPopulationDecorator);
    }

    public function testRender()
    {
        $numberPopulationDecorator = new TextPopulationDecoratorHtml($this->textPopulation->reveal());
        $render = $numberPopulationDecorator->render();
        $this->assertEquals('abc' . '<br>' . PHP_EOL . 'def' . '<br>' . PHP_EOL . 'ghi' . '<br>' . PHP_EOL, $render);
    }
}
