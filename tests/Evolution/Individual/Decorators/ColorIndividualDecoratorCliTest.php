<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\ColorIndividualDecoratorCli;
use Prophecy\Prophet;

class ColorIndividualDecoratorCliTest extends \PHPUnit_Framework_TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testStatisticsObjectCreation()
    {
        $colorIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual');
        $colorIndividualDecorator = new ColorIndividualDecoratorCli($colorIndividual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Individual\Decorators\ColorIndividualDecoratorCli', $colorIndividualDecorator);
    }

    public function testRender()
    {
        $color = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Color\Color');
        $color->getHex()->willReturn('000');
        $colorIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual');
        $colorIndividual->getObject()->willReturn($color);

        $colorIndividualDecorator = new ColorIndividualDecoratorCli($colorIndividual->reveal());
        $render = $colorIndividualDecorator->render();
        $this->assertEquals('000' . PHP_EOL, $render);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
