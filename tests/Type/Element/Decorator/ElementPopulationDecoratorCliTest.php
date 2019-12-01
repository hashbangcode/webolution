<?php

namespace Hashbangcode\Webolution\Test\Type\Element\Decorator;

use Hashbangcode\Webolution\Type\Element\Decorator\ElementPopulationDecoratorCli;
use Prophecy\Prophet;

class ElementPopulationDecoratorCliTest extends ElementPopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Element\ElementPopulation');
        $numberPopulationDecorator = new ElementPopulationDecoratorCli($numberPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Element\Decorator\ElementPopulationDecoratorCli', $numberPopulationDecorator);
    }

    public function testRender()
    {
        $numberPopulationDecorator = new ElementPopulationDecoratorCli($this->textPopulation->reveal());
        $render = $numberPopulationDecorator->render();
        $this->assertEquals('<div class="testdiv"></div><p class="testp">text</p><div class="testdiv2"></div>', $render);
    }
}
