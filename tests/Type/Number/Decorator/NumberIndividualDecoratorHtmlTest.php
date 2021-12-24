<?php

namespace Hashbangcode\Webolution\Test\Type\Number\Decorator;

use Hashbangcode\Webolution\Type\Number\Decorator\NumberIndividualDecoratorHtml;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class NumberIndividualDecoratorHtmlTest extends TestCase
{

    private $prophet;

    public function setup(): void
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Number\NumberIndividual');
        $individualDecorator = new NumberIndividualDecoratorHtml($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Number\Decorator\NumberIndividualDecoratorHtml', $individualDecorator);
    }

    public function testRender()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Number\Number');
        $object->getNumber()->willReturn(123);
        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Number\NumberIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new NumberIndividualDecoratorHtml($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();
        $this->assertEquals(123 . '<br>', $render);
    }

    protected function tearDown(): void
    {
        $this->prophet->checkPredictions();
    }
}
