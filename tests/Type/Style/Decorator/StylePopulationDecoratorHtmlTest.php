<?php

namespace Hashbangcode\Webolution\Test\Type\Style\Decorator;

use Hashbangcode\Webolution\Type\Style\Decorator\StylePopulationDecoratorHtml;
use Prophecy\Prophet;

class StylePopulationDecoratorHtmlTest extends StylePopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Style\StylePopulation');
        $numberPopulationDecorator = new StylePopulationDecoratorHtml($numberPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Style\Decorator\StylePopulationDecoratorHtml', $numberPopulationDecorator);
    }

    public function testRender()
    {
        $numberPopulationDecorator = new StylePopulationDecoratorHtml($this->textPopulation->reveal());
        $render = $numberPopulationDecorator->render();
        $this->assertEquals('div{color:red;}p{color:red;}div.test{color:red;}', $render);
    }
}
