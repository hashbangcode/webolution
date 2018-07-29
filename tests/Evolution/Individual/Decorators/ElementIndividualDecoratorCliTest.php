<?php

namespace Hashbangcode\Webolution\Test\Evolution\Individual\Decorators;

use Hashbangcode\Webolution\Evolution\Individual\Decorators\ElementIndividualDecoratorCli;
use Prophecy\Prophet;

class ElementIndividualDecoratorCliTest extends \PHPUnit_Framework_TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Individual\ElementIndividual');
        $individualDecorator = new ElementIndividualDecoratorCli($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Evolution\Individual\Decorators\ElementIndividualDecoratorCli', $individualDecorator);
    }

    public function testRenderEmptyElement()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Element\Element');
        $object->getType()->willReturn('div');
        $object->getAttributes()->willReturn(null);
        $object->getChildren()->willReturn([]);
        $object->getElementText()->willReturn('');

        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Individual\ElementIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new ElementIndividualDecoratorCli($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();

        $this->assertEquals('<div></div>', $render);
    }

    public function testRenderElementWithAttribute()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Element\Element');
        $object->getType()->willReturn('div');
        $object->getAttributes()->willReturn(['class' => 'class']);
        $object->getChildren()->willReturn([]);
        $object->getElementText()->willReturn('');

        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Individual\ElementIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new ElementIndividualDecoratorCli($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();

        $this->assertEquals('<div class="class"></div>', $render);
    }

    public function testRenderElementWithAttributeAndText()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Element\Element');
        $object->getType()->willReturn('div');
        $object->getAttributes()->willReturn(['class' => 'class']);
        $object->getChildren()->willReturn([]);
        $object->getElementText()->willReturn('text');

        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Individual\ElementIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new ElementIndividualDecoratorCli($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();

        $this->assertEquals('<div class="class">text</div>', $render);
    }

    public function testRenderElementWithChild()
    {
        $child = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Element\Element');
        $child->getType()->willReturn('p');
        $child->getAttributes()->willReturn(null);
        $child->getChildren()->willReturn([]);
        $child->getElementText()->willReturn('');

        $childIndividual = new \Hashbangcode\Webolution\Evolution\Individual\ElementIndividual($child->reveal());

        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Element\Element');
        $object->getType()->willReturn('div');
        $object->getAttributes()->willReturn(['class' => 'class']);
        $object->getChildren()->willReturn([$childIndividual]);
        $object->getElementText()->willReturn('');

        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Individual\ElementIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new ElementIndividualDecoratorCli($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();

        $this->assertEquals('<div class="class"><p></p></div>', $render);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
