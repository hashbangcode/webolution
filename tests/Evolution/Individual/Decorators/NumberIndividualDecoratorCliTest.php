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
        $individual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual');
        $idividualDecorator = new NumberIndividualDecoratorCli($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Individual\Decorators\NumberIndividualDecoratorCli', $idividualDecorator);
    }

    public function testRender()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Number\Number');
        $object->getNumber()->willReturn(123);
        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new NumberIndividualDecoratorCli($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();
        $this->assertEquals(123 . PHP_EOL, $render);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
