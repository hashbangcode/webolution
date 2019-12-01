<?php

namespace Hashbangcode\Webolution\Test\Type\Number\Decorator;

use Hashbangcode\Webolution\Type\Number\Decorator\NumberIndividualDecoratorCli;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class NumberIndividualDecoratorCliTest extends TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Number\NumberIndividual');
        $idividualDecorator = new NumberIndividualDecoratorCli($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Number\Decorator\NumberIndividualDecoratorCli', $idividualDecorator);
    }

    public function testRender()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Number\Number');
        $object->getNumber()->willReturn(123);
        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Number\NumberIndividual');
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
