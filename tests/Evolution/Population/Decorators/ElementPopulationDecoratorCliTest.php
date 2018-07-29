<?php

namespace Hashbangcode\Webolution\Test\Evolution\Population\Decorators;

use Hashbangcode\Webolution\Test\Evolution\Population\Decorators\ElementPopulationDecoratorTestBase;
use Hashbangcode\Webolution\Evolution\Population\Decorators\ElementPopulationDecoratorCli;
use Prophecy\Prophet;

class ElementPopulationDecoratorCliTest extends ElementPopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Population\ElementPopulation');
        $numberPopulationDecorator = new ElementPopulationDecoratorCli($numberPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Evolution\Population\Decorators\ElementPopulationDecoratorCli', $numberPopulationDecorator);
    }

    public function testRender()
    {
        $numberPopulationDecorator = new ElementPopulationDecoratorCli($this->textPopulation->reveal());
        $render = $numberPopulationDecorator->render();
        $this->assertEquals('<div class="testdiv"></div><p class="testp">text</p><div class="testdiv2"></div>', $render);
    }
}
