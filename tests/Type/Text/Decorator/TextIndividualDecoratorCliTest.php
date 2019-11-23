<?php

namespace Hashbangcode\Webolution\Test\Type\Text\Decorator;

use Hashbangcode\Webolution\Type\Text\Decorator\TextIndividualDecoratorCli;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class TextIndividualDecoratorCliTest extends TestCase
{
    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Text\TextIndividual');
        $individualDecorator = new TextIndividualDecoratorCli($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Text\Decorator\TextIndividualDecoratorCli', $individualDecorator);
    }

    public function testRender()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Text\Text');
        $object->getText()->willReturn('abc');
        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Text\TextIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new TextIndividualDecoratorCli($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();
        $this->assertEquals('abc' . PHP_EOL, $render);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
