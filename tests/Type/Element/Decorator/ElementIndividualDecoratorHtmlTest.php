<?php

namespace Hashbangcode\Webolution\Test\Type\Element\Decorator;

use Hashbangcode\Webolution\Type\Element\Decorator\ElementIndividualDecoratorHtml;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class ElementIndividualDecoratorHtmlTest extends TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Element\ElementIndividual');
        $individualDecorator = new ElementIndividualDecoratorHtml($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Element\Decorator\ElementIndividualDecoratorHtml', $individualDecorator);
    }

    public function testRenderEmptyElement()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Element\Element');
        $object->getType()->willReturn('div');
        $object->getAttributes()->willReturn(null);
        $object->getChildren()->willReturn([]);
        $object->getElementText()->willReturn('');

        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Element\ElementIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new ElementIndividualDecoratorHtml($objectIndividual->reveal());
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

        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Element\ElementIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new ElementIndividualDecoratorHtml($objectIndividual->reveal());
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

        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Element\ElementIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new ElementIndividualDecoratorHtml($objectIndividual->reveal());
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

        $childIndividual = new \Hashbangcode\Webolution\Type\Element\ElementIndividual($child->reveal());

        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Element\Element');
        $object->getType()->willReturn('div');
        $object->getAttributes()->willReturn(['class' => 'class']);
        $object->getChildren()->willReturn([$childIndividual]);
        $object->getElementText()->willReturn('');

        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Element\ElementIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new ElementIndividualDecoratorHtml($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();

        $this->assertEquals('<div class="class"><p></p></div>', $render);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
