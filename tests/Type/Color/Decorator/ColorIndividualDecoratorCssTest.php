<?php

namespace Hashbangcode\Webolution\Test\Type\Color\Decorator;

use Hashbangcode\Webolution\Type\Color\Decorator\ColorIndividualDecoratorCss;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class ColorIndividualDecoratorCssTest extends TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Color\ColorIndividual');
        $ndividualDecorator = new ColorIndividualDecoratorCss($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Color\Decorator\ColorIndividualDecoratorCss', $ndividualDecorator);
    }

    public function testRender()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Color\Color');
        $object->getHex()->willReturn('000');
        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Color\ColorIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new ColorIndividualDecoratorCss($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();
        $this->assertEquals('#000', $render);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
