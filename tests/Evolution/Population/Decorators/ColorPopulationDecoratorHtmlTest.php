<?php

namespace Hashbangcode\Webolution\Test\Evolution\Population\Decorators;

use Hashbangcode\Webolution\Test\Evolution\Population\Decorators\NumberPopulationDecoratorTestBase;
use Hashbangcode\Webolution\Evolution\Population\Decorators\ColorPopulationDecoratorHtml;
use Prophecy\Prophet;

class ColorPopulationDecoratorHtmlTest extends ColorPopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $colorPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Population\ColorPopulation');
        $colorPopulationDecorator = new ColorPopulationDecoratorHtml($colorPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Evolution\Population\Decorators\ColorPopulationDecoratorHtml', $colorPopulationDecorator);
    }

    public function testRender()
    {
        $colorPopulationDecorator = new ColorPopulationDecoratorHtml($this->colorPopulation->reveal());
        $render = $colorPopulationDecorator->render();
        $this->assertEquals('<span style="background-color:#000"> </span><span style="background-color:#555"> </span><span style="background-color:#fff"> </span>', $render);
    }
}
