<?php

namespace Hashbangcode\Webolution\Test\Type\Color\Decorator;

use Hashbangcode\Webolution\Test\Type\Number\Decorator\NumberPopulationDecoratorTestBase;
use Hashbangcode\Webolution\Type\Color\Decorator\ColorPopulationDecoratorHtml;
use Prophecy\Prophet;

class ColorPopulationDecoratorHtmlTest extends ColorPopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $colorPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Color\ColorPopulation');
        $colorPopulationDecorator = new ColorPopulationDecoratorHtml($colorPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Color\Decorator\ColorPopulationDecoratorHtml', $colorPopulationDecorator);
    }

    public function testRender()
    {
        $colorPopulationDecorator = new ColorPopulationDecoratorHtml($this->colorPopulation->reveal());
        $render = $colorPopulationDecorator->render();
        $this->assertEquals('<span style="background-color:#000"> </span><span style="background-color:#555"> </span><span style="background-color:#fff"> </span>', $render);
    }
}
