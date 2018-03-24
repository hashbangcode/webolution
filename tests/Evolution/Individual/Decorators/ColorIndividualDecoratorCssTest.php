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
        $colorIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual');
        $colorIndividualDecorator = new ColorIndividualDecoratorCss($colorIndividual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Individual\Decorators\ColorIndividualDecoratorCss', $colorIndividualDecorator);
    }

    public function testRender()
    {
        $color = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Color\Color');
        $color->getHex()->willReturn('000');
        $colorIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual');
        $colorIndividual->getObject()->willReturn($color);

        $colorIndividualDecorator = new ColorIndividualDecoratorCss($colorIndividual->reveal());
        $render = $colorIndividualDecorator->render();
        $this->assertEquals('#000', $render);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
