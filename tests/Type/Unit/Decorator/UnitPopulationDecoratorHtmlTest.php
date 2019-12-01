<?php

namespace Hashbangcode\Webolution\Test\Type\Unit\Decorator;

use Hashbangcode\Webolution\Type\Unit\Decorator\UnitPopulationDecoratorHtml;
use Prophecy\Prophet;

class UnitPopulationDecoratorHtmlTest extends UnitPopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $unitPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Unit\UnitPopulation');
        $unitPopulationDecorator = new UnitPopulationDecoratorHtml($unitPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Unit\Decorator\UnitPopulationDecoratorHtml', $unitPopulationDecorator);
    }

    public function testRender()
    {
        $unitPopulationDecorator = new UnitPopulationDecoratorHtml($this->unitPopulation->reveal());
        $render = $unitPopulationDecorator->render();
        $this->assertEquals('1em1px1%', $render);
    }
}
