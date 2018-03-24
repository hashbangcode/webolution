<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\TextIndividualDecoratorHtml;
use Prophecy\Prophet;

class TextIndividualDecoratorHtmlTest extends \PHPUnit_Framework_TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\TextIndividual');
        $individualDecorator = new TextIndividualDecoratorHtml($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Individual\Decorators\TextIndividualDecoratorHtml', $individualDecorator);
    }

    public function testRender()
    {
        $color = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Text\Text');
        $color->getText()->willReturn('abc');
        $colorIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\TextIndividual');
        $colorIndividual->getObject()->willReturn($color);

        $colorIndividualDecorator = new TextIndividualDecoratorHtml($colorIndividual->reveal());
        $render = $colorIndividualDecorator->render();
        $this->assertEquals('abc' . '<br>' . PHP_EOL, $render);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
