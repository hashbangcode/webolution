<?php

namespace Hashbangcode\Webolution\Test\Type\Number\Decorator;

use Hashbangcode\Webolution\Type\Number\Decorator\NumberPopulationDecoratorHtml;
use Prophecy\Prophet;

class NumberPopulationDecoratorHtmlTest extends NumberPopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Number\NumberPopulation');
        $numberPopulationDecorator = new NumberPopulationDecoratorHtml($numberPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Number\Decorator\NumberPopulationDecoratorHtml', $numberPopulationDecorator);
    }

    public function testRender()
    {
        $numberPopulationDecorator = new NumberPopulationDecoratorHtml($this->numberPopulation->reveal());
        $render = $numberPopulationDecorator->render();
        $this->assertEquals(1 . '<br>' . 2 . '<br>' . 3 . '<br>', $render);
    }
}
