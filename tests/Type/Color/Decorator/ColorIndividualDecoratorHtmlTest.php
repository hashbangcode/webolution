<?php

namespace Hashbangcode\Webolution\Test\Type\Color\Decorator;

use Hashbangcode\Webolution\Type\Color\Decorator\ColorIndividualDecoratorHtml;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class ColorIndividualDecoratorHtmlTest extends TestCase
{

    private $prophet;

    public function setup(): void
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Color\ColorIndividual');
        $individualDecorator = new ColorIndividualDecoratorHtml($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Color\Decorator\ColorIndividualDecoratorHtml', $individualDecorator);
    }

    public function testRender()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Color\Color');
        $object->getHex()->willReturn('000');
        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Color\ColorIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new ColorIndividualDecoratorHtml($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();
        $this->assertEquals('<span style="background-color:#000"> </span>', $render);
    }

    protected function tearDown(): void
    {
        $this->prophet->checkPredictions();
    }
}
