<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Test\Evolution\Population\Decorators\NumberPopulationDecoratorTestBase;
use Hashbangcode\Wevolution\Evolution\Population\Decorators\NumberPopulationDecoratorHtml;
use Prophecy\Prophet;

class NumberPopulationDecoratorHtmlTest extends NumberPopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Population\NumberPopulation');
        $numberPopulationDecorator = new NumberPopulationDecoratorHtml($numberPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Population\Decorators\NumberPopulationDecoratorHtml', $numberPopulationDecorator);
    }

    public function testRender()
    {
        $numberPopulationDecorator = new NumberPopulationDecoratorHtml($this->numberPopulation->reveal());
        $render = $numberPopulationDecorator->render();
        $this->assertEquals(1 . '<br>' . 2 . '<br>' . 3 . '<br>', $render);
    }
}
