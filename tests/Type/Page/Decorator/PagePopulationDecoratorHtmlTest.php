<?php

namespace Hashbangcode\Webolution\Test\Type\Page\Decorator;

use Hashbangcode\Webolution\Type\Page\Decorator\PagePopulationDecoratorHtml;
use Prophecy\Prophet;

class PagePopulationDecoratorHtmlTest extends PagePopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Page\PagePopulation');
        $numberPopulationDecorator = new PagePopulationDecoratorHtml($numberPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Page\Decorator\PagePopulationDecoratorHtml', $numberPopulationDecorator);
    }

    public function testRender()
    {
        $numberPopulationDecorator = new PagePopulationDecoratorHtml($this->textPopulation->reveal());
        $render = $numberPopulationDecorator->render();
        $this->assertStringEqualsFile(__DIR__ . '/data/page01html.txt', $render);
    }
}
