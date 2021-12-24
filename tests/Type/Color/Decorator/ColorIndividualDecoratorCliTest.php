<?php

namespace Hashbangcode\Webolution\Test\Type\Color\Decorator;

use Hashbangcode\Webolution\Type\Color\Decorator\ColorIndividualDecoratorCli;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class ColorIndividualDecoratorCliTest extends TestCase
{

    private $prophet;

    public function setup(): void
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Color\ColorIndividual');
        $individualDecorator = new ColorIndividualDecoratorCli($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Color\Decorator\ColorIndividualDecoratorCli', $individualDecorator);
    }

    public function testRender()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Color\Color');
        $object->getHex()->willReturn('000');
        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Color\ColorIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new ColorIndividualDecoratorCli($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();
        $this->assertEquals('000' . PHP_EOL, $render);
    }

    protected function tearDown(): void
    {
        $this->prophet->checkPredictions();
    }
}
