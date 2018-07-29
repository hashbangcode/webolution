<?php

namespace Hashbangcode\Webolution\Test\Evolution\Population\Decorators;

use Hashbangcode\Webolution\Test\Evolution\Population\Decorators\ColorPopulationDecoratorTestBase;
use Hashbangcode\Webolution\Evolution\Population\Decorators\ColorPopulationDecoratorCli;
use Prophecy\Prophet;

class ColorPopulationDecoratorCliTest extends ColorPopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $colorPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Population\ColorPopulation');
        $colorPopulationDecorator = new ColorPopulationDecoratorCli($colorPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Evolution\Population\Decorators\ColorPopulationDecoratorCli', $colorPopulationDecorator);
    }

    public function testRender()
    {
        $colorPopulationDecorator = new ColorPopulationDecoratorCli($this->colorPopulation->reveal());
        $render = $colorPopulationDecorator->render();
        $this->assertEquals('000' . PHP_EOL . '555' . PHP_EOL . 'fff' . PHP_EOL, $render);
    }
}
