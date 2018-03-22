<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\NumberIndividualDecoratorHtml;
use Prophecy\Prophet;

class NumberIndividualDecoratorHtmlTest extends \PHPUnit_Framework_TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testStatisticsObjectCreation()
    {
        $numberIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual');
        $numberIndividualDecorator = new NumberIndividualDecoratorHtml($numberIndividual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Individual\Decorators\NumberIndividualDecoratorHtml', $numberIndividualDecorator);
    }

    public function testRender()
    {
        $number = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Number\Number');
        $number->getNumber()->willReturn(123);
        $numberIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual');
        $numberIndividual->getObject()->willReturn($number);

        $numberIndividualDecorator = new NumberIndividualDecoratorHtml($numberIndividual->reveal());
        $render = $numberIndividualDecorator->render();
        $this->assertEquals(123 . '<br>', $render);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
