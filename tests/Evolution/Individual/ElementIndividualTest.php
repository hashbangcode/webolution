<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual;

use Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual;
use Hashbangcode\Wevolution\Type\Element\Element;

/**
 * Test class for ColorIndividual
 */
class ElementIndividualTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateIndividual()
    {
        $object = new ElementIndividual(new Element('div'));
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Element\Element', $object->getObject());
    }

    public function testMutateElementThroughIndividual()
    {
        $html = new Element('html');
        $body = new Element('body');
        $html->addChild($body);

        $object = new ElementIndividual($html);

        $object->mutate();
        $this->assertEquals('html', $object->getObject()->getType());
    }

    public function testMutateElementThroughIndividualWithDifferentFactor()
    {

        $html = new Element('html');
        $body = new Element('body');
        $html->addChild($body);

        $object = new ElementIndividual($html);

        $object->mutate(-10);
        $this->assertEquals('html', $object->getObject()->getType());
    }

    public function testGetElementIndividualFitness()
    {
        $object = new ElementIndividual(new Element('div'));
        $this->assertEquals(1, $object->getFitness());
        $object->getObject()->setType('p');
        $this->assertEquals(1, $object->getFitness());
    }

    public function testElementIndividualCliRenderWithObject()
    {
        $object = new ElementIndividual(new Element('html'));
        $renderType = 'cli';
        $this->assertEquals('<html></html>' . PHP_EOL, $object->render($renderType));
    }

    public function testElementIndividualCliRenderWithString()
    {
        $object = new ElementIndividual('html');
        $renderType = 'cli';
        $this->assertEquals('<html></html>' . PHP_EOL, $object->render($renderType));
    }

    public function testElementIndividualHtmlRenderWithObject()
    {
        $object = new ElementIndividual(new Element('html'));
        $renderType = 'html';
        $this->assertEquals('<html></html>', $object->render($renderType));
    }

    public function testElementIndividualHtmlRenderWithString()
    {
        $object = new ElementIndividual('html');
        $renderType = 'html';
        $this->assertEquals('<html></html>', $object->render($renderType));
    }

    public function testMutateElementAttribute()
    {
        $html = new Element('html');
        $body = new Element('body');
        $html->addChild($body);

        $object = new ElementIndividual($html);

        $rootElement = $object->getObject();
        $element = $rootElement->getChildren()[0];
        $element->setAttributes(array('class' => 'test'));

        $object->mutate(-10);
        $this->assertContains('<html><body class="test"><', $object->render());
    }

    public function testMutateElementAttributeLength()
    {
        $div = new Element('div');
        $div->setAttributes(array('class' => 'test'));

        $object = new ElementIndividual($div);

        for ($i = 0; $i < 25; ++$i) {
            $object->mutateAttribute();
        }

        $this->assertLessThanOrEqual(10, $object->getObject()->getAttributes()['class']);
    }

    public function testMutateElementChild()
    {
        $html = new Element('html');
        $body = new Element('body');
        $html->addChild($body);

        $object = new ElementIndividual($html);

        $this->assertEquals(1, count($object->getObject()->getChildren()));

        $object->getObject()->setAttributes(array('class' => 'test'));
        $object->mutate(100);
        $this->assertStringStartsWith('test', $object->getObject()->getAttributes()['class']);

        $this->assertEquals(1, count($object->getObject()->getChildren()));
    }

    public function testMutateWithNoAttributes()
    {
        $element1 = new Element('div');
        $element2 = new Element('p');
        $element1->addChild($element2);

        $object = new ElementIndividual($element1);

        $this->assertEquals(2, count($object->getObject()->getAllElements()));
        $object->mutate();
    }
}
