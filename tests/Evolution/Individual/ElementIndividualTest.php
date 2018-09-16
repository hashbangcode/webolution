<?php

namespace Hashbangcode\Webolution\Test\Evolution\Individual;

use Hashbangcode\Webolution\Evolution\Individual\ElementIndividual;
use Hashbangcode\Webolution\Type\Element\Element;

/**
 * Test class for ColorIndividual
 */
class ElementIndividualTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateIndividual()
    {
        $object = new ElementIndividual(new Element('div'));
        $this->assertInstanceOf('Hashbangcode\Webolution\Evolution\Individual\ElementIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Element\Element', $object->getObject());
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

        $object->mutate(-100);
        $this->assertEquals('html', $object->getObject()->getType());
    }

    public function testGetElementIndividualFitness()
    {
        $object = new ElementIndividual(new Element('div'));
        $this->assertEquals(2, $object->getFitness());
        $object->getObject()->setType('p');
        $this->assertEquals(2, $object->getFitness());
        $object->getObject()->setAttribute('class', 'test');
        $this->assertEquals(3, $object->getFitness());
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
