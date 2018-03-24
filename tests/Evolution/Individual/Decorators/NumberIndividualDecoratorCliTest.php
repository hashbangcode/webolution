<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\NumberIndividualDecoratorCli;
use Prophecy\Prophet;

class NumberIndividualDecoratorCliTest extends \PHPUnit_Framework_TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $numberIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual');
        $numberIndividualDecorator = new NumberIndividualDecoratorCli($numberIndividual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Individual\Decorators\NumberIndividualDecoratorCli', $numberIndividualDecorator);
    }

    public function testRender()
    {
        $number = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Number\Number');
        $number->getNumber()->willReturn(123);
        $numberIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual');
        $numberIndividual->getObject()->willReturn($number);

        $numberIndividualDecorator = new NumberIndividualDecoratorCli($numberIndividual->reveal());
        $render = $numberIndividualDecorator->render();
        $this->assertEquals(123 . PHP_EOL, $render);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
