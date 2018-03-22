<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\ColorIndividualDecoratorHtml;
use Prophecy\Prophet;

class ColorIndividualDecoratorHtmlTest extends \PHPUnit_Framework_TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testStatisticsObjectCreation()
    {
        $colorIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual');
        $colorIndividualDecorator = new ColorIndividualDecoratorHtml($colorIndividual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Individual\Decorators\ColorIndividualDecoratorHtml', $colorIndividualDecorator);
    }

    public function testRender()
    {
        $color = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Color\Color');
        $color->render()->willReturn('000');
        $colorIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual');
        $colorIndividual->getObject()->willReturn($color);

        $colorIndividualDecorator = new ColorIndividualDecoratorHtml($colorIndividual->reveal());
        $render = $colorIndividualDecorator->render();
        $this->assertEquals('<span style="background-color:#000"> </span>', $render);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
