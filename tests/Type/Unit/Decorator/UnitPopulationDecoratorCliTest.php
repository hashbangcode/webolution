<?php

namespace Hashbangcode\Webolution\Test\Type\Unit\Decorator;

use Hashbangcode\Webolution\Type\Unit\Decorator\UnitPopulationDecoratorCli;
use Prophecy\Prophet;

class UnitPopulationDecoratorCliTest extends UnitPopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $unitPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Unit\UnitPopulation');
        $unitPopulationDecorator = new UnitPopulationDecoratorCli($unitPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Unit\Decorator\UnitPopulationDecoratorCli', $unitPopulationDecorator);
    }

    public function testRender()
    {
        $unitPopulationDecorator = new UnitPopulationDecoratorCli($this->unitPopulation->reveal());
        $render = $unitPopulationDecorator->render();
        $this->assertEquals('1em1px1%', $render);
    }
}
