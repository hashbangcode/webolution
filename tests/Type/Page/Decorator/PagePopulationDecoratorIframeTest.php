<?php

namespace Hashbangcode\Webolution\Test\Type\Page\Decorator;

use Hashbangcode\Webolution\Type\Page\Decorator\PagePopulationDecoratorIframe;
use Prophecy\Prophet;

class PagePopulationDecoratorIframeTest extends PagePopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Page\PagePopulation');
        $numberPopulationDecorator = new PagePopulationDecoratorIframe($numberPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Page\Decorator\PagePopulationDecoratorIframe', $numberPopulationDecorator);
    }

    public function testRender()
    {
        $numberPopulationDecorator = new PagePopulationDecoratorIframe($this->textPopulation->reveal());
        $render = $numberPopulationDecorator->render();
        $this->assertStringEqualsFile(__DIR__ . '/data/pagepopulationiframe01.html', $render);
    }
}
