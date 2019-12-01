<?php

namespace Hashbangcode\Webolution\Test\Type\Color\Decorator;

use Hashbangcode\Webolution\Test\Type\Color\Decorator\ColorPopulationDecoratorTestBase;
use Hashbangcode\Webolution\Type\Color\Decorator\ColorPopulationDecoratorCli;
use Prophecy\Prophet;

class ColorPopulationDecoratorCliTest extends ColorPopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $colorPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Color\ColorPopulation');
        $colorPopulationDecorator = new ColorPopulationDecoratorCli($colorPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Color\Decorator\ColorPopulationDecoratorCli', $colorPopulationDecorator);
    }

    public function testRender()
    {
        $colorPopulationDecorator = new ColorPopulationDecoratorCli($this->colorPopulation->reveal());
        $render = $colorPopulationDecorator->render();
        $this->assertEquals('000' . PHP_EOL . '555' . PHP_EOL . 'fff' . PHP_EOL, $render);
    }
}
