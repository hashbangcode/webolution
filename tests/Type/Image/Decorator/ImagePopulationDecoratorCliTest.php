<?php

namespace Hashbangcode\Webolution\Test\Type\Image\Decorator;

use Hashbangcode\Webolution\Type\Image\Decorator\ImagePopulationDecoratorCli;
use Prophecy\Prophet;

class ImagePopulationDecoratorCliTest extends ImagePopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $imagePopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Image\ImagePopulation');
        $imagePopulationDecorator = new ImagePopulationDecoratorCli($imagePopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Image\Decorator\ImagePopulationDecoratorCli', $imagePopulationDecorator);
    }

    public function testRender()
    {
        $imagePopulationDecorator = new ImagePopulationDecoratorCli($this->imagePopulation->reveal());
        $render = $imagePopulationDecorator->render();
        $this->assertStringEqualsFile(__DIR__ . '/data/imagePopulationCli01.txt', $render);
    }
}
