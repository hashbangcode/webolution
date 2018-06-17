<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Test\Evolution\Population\Decorators\PagePopulationDecoratorTestBase;
use Hashbangcode\Wevolution\Evolution\Population\Decorators\PagePopulationDecoratorHtml;
use Prophecy\Prophet;

class PagePopulationDecoratorHtmlTest extends PagePopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Population\PagePopulation');
        $numberPopulationDecorator = new PagePopulationDecoratorHtml($numberPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Population\Decorators\PagePopulationDecoratorHtml', $numberPopulationDecorator);
    }

    public function testRender()
    {
        $numberPopulationDecorator = new PagePopulationDecoratorHtml($this->textPopulation->reveal());
        $render = $numberPopulationDecorator->render();
        $this->assertStringEqualsFile('tests/Evolution/Population/Decorators/data/page01html.txt', $render);
    }
}