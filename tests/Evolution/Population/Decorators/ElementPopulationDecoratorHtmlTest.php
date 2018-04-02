<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Test\Evolution\Population\Decorators\ElementPopulationDecoratorTestBase;
use Hashbangcode\Wevolution\Evolution\Population\Decorators\ElementPopulationDecoratorHtml;
use Prophecy\Prophet;

class ElementPopulationDecoratorHtmlTest extends ElementPopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Population\ElementPopulation');
        $numberPopulationDecorator = new ElementPopulationDecoratorHtml($numberPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Population\Decorators\ElementPopulationDecoratorHtml', $numberPopulationDecorator);
    }

    public function testRender()
    {
        $numberPopulationDecorator = new ElementPopulationDecoratorHtml($this->textPopulation->reveal());
        $render = $numberPopulationDecorator->render();
        $this->assertEquals('<div class="testdiv"></div><p class="testp">text</p><div class="testdiv2"></div>', $render);
    }
}
