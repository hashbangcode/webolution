<?php

namespace Hashbangcode\Webolution\Test\Type\Element\Decorator;

use Hashbangcode\Webolution\Type\Element\Decorator\ElementPopulationDecoratorHtml;
use Prophecy\Prophet;

class ElementPopulationDecoratorHtmlTest extends ElementPopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Element\ElementPopulation');
        $numberPopulationDecorator = new ElementPopulationDecoratorHtml($numberPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Element\Decorator\ElementPopulationDecoratorHtml', $numberPopulationDecorator);
    }

    public function testRender()
    {
        $numberPopulationDecorator = new ElementPopulationDecoratorHtml($this->textPopulation->reveal());
        $render = $numberPopulationDecorator->render();
        $this->assertEquals('<div class="testdiv"></div><p class="testp">text</p><div class="testdiv2"></div>', $render);
    }
}
