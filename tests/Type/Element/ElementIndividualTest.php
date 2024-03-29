<?php

namespace Hashbangcode\Webolution\Test\Type\Element;

use Hashbangcode\Webolution\Type\Element\ElementIndividual;
use Hashbangcode\Webolution\Type\Element\Element;
use PHPUnit\Framework\TestCase;

/**
 * Test class for ColorIndividual
 */
class ElementIndividualTest extends TestCase
{

    public function testCreateIndividual()
    {
        $object = new ElementIndividual(new Element('div'));

        $this->assertEquals('1', $object->getName());
        $this->assertEquals('1', $object->getSpecies());

        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Element\ElementIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Element\Element', $object->getObject());
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

        $this->assertLessThanOrEqual(10, strlen($object->getObject()->getAttributes()['class']));
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
