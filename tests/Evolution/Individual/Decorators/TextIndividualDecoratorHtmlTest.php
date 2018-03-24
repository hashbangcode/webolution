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
        $object = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Text\Text');
        $object->getText()->willReturn('abc');
        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\TextIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new TextIndividualDecoratorHtml($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();
        $this->assertEquals('abc' . '<br>' . PHP_EOL, $render);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
