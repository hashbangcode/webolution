<?php

namespace Hashbangcode\Webolution\Test\Type\Style\Decorator;

use Hashbangcode\Webolution\Type\Style\Decorator\StylePopulationDecoratorCli;
use Prophecy\Prophet;

class StylePopulationDecoratorCliTest extends StylePopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Style\StylePopulation');
        $numberPopulationDecorator = new StylePopulationDecoratorCli($numberPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Style\Decorator\StylePopulationDecoratorCli', $numberPopulationDecorator);
    }

    public function testRender()
    {
        $numberPopulationDecorator = new StylePopulationDecoratorCli($this->textPopulation->reveal());
        $render = $numberPopulationDecorator->render();
        $this->assertEquals('div{color:red;}p{color:red;}div.test{color:red;}', $render);
    }
}
