<?php

namespace Hashbangcode\Webolution\Test\Type\Color\Decorator;

use Hashbangcode\Webolution\Test\Type\Color\Decorator\ColorPopulationDecoratorTestBase;
use Hashbangcode\Webolution\Type\Color\Decorator\ColorPopulationDecoratorCss;
use Prophecy\Prophet;

class ColorPopulationDecoratorCssTest extends ColorPopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $colorPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Color\ColorPopulation');
        $colorPopulationDecorator = new ColorPopulationDecoratorCss($colorPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Color\Decorator\ColorPopulationDecoratorCss', $colorPopulationDecorator);
    }

    public function testRender()
    {
        $colorPopulationDecorator = new ColorPopulationDecoratorCss($this->colorPopulation->reveal());
        $render = $colorPopulationDecorator->render();
        $this->assertEquals('#000#555#fff', $render);
    }
}
