<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\ColorIndividualDecoratorCss;
use Prophecy\Prophet;

class ColorIndividualDecoratorCssTest extends \PHPUnit_Framework_TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual');
        $ndividualDecorator = new ColorIndividualDecoratorCss($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Individual\Decorators\ColorIndividualDecoratorCss', $ndividualDecorator);
    }

    public function testRender()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Color\Color');
        $object->getHex()->willReturn('000');
        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual');
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
