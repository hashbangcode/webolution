<?php

namespace Hashbangcode\Webolution\Test\Type\Text\Decorator;

use Hashbangcode\Webolution\Type\Text\Decorator\TextIndividualDecoratorHtml;
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
        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Text\TextIndividual');
        $individualDecorator = new TextIndividualDecoratorHtml($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Text\Decorator\TextIndividualDecoratorHtml', $individualDecorator);
    }

    public function testRender()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Text\Text');
        $object->getText()->willReturn('abc');
        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Text\TextIndividual');
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
