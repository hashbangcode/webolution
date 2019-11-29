<?php

namespace Hashbangcode\Webolution\Test\Type\Image\Decorator;

use Hashbangcode\Webolution\Test\Type\Image\Decorator\ImagePopulationDecoratorTestBase;
use Hashbangcode\Webolution\Type\Image\Decorator\ImagePopulationDecoratorHtml;
use Prophecy\Prophet;

class ImagePopulationDecoratorHtmlTest extends ImagePopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $imagePopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Image\ImagePopulation');
        $imagePopulationDecorator = new ImagePopulationDecoratorHtml($imagePopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Image\Decorator\ImagePopulationDecoratorHtml', $imagePopulationDecorator);
    }

    public function testRender()
    {
        $imagePopulationDecorator = new ImagePopulationDecoratorHtml($this->imagePopulation->reveal());
        $render = $imagePopulationDecorator->render();
        $this->assertStringMatchesFormat('<img width="110" height="110" src="data:image/jpg;base64%s" /> <img width="110" height="110" src="data:image/jpg;base64%s" /> <img width="110" height="110" src="data:image/jpg;base64%s" /> ', $render);
    }
}
