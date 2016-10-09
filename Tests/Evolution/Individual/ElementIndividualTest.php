<?php

use Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual;
use Hashbangcode\Wevolution\Type\Element\Element;

/**
 * Test class for ColorIndividual
 */
class ElementIndividualTest extends PHPUnit_Framework_TestCase
{

  public function testCreateElementIndividual() {
    $object = new ElementIndividual(new Element('div'));
    $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual', $object);
    $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Element\Element', $object->getObject());
  }

  public function testMutateElementThroughIndividual() {
    $object = new ElementIndividual(new Element('div'));
    $object->mutateProperties();
    $this->assertEquals('div', $object->getObject()->getType());
  }

  public function testMutateElementThroughIndividualWithDifferentFactor() {
    $object = new ElementIndividual(new Element('div'));
    $object->setMutationFactor(-10);
    $object->mutateProperties();
    $this->assertEquals('div', $object->getObject()->getType());
    $this->assertEquals(-10, $object->getMutationFactor());
  }

  public function testGetElementIndividualFitness() {
    $object = new ElementIndividual(new Element('div'));
    $this->assertEquals(1, $object->getFitness());
    $object->getObject()->setType('p');
    $this->assertEquals(1, $object->getFitness());
  }

  public function testElementIndividualRender() {
    $object = new ElementIndividual(new Element('html'));
    $renderType = 'cli';
    $this->assertEquals('<html></html>', $object->render($renderType));
  }

  public function testMutateElementAttribute() {
    $object = new ElementIndividual(new Element('div'));
    $object->getObject()->setAttributes(array('class' => 'test'));
    $object->mutateElement(-10);
    $this->assertNotEquals('test', $object->getObject()->getAttributes()['class']);
  }

  public function testMutateElementAttributeLength() {
    $object = new ElementIndividual(new Element('div'));
    $object->getObject()->setAttributes(array('class' => 'test'));
    for ($i = 0; $i < 25; ++$i) {
      $object->mutateElement(-10);
    }
    $this->assertNotEquals('test', $object->getObject()->getAttributes()['class']);
    $this->assertLessThanOrEqual(10, $object->getObject()->getAttributes()['class']);
  }

  public function testMutateElementChild() {
    $object = new ElementIndividual(new Element('div'));
    $this->assertEquals(0, count($object->getObject()->getChildren()));
    $object->getObject()->setAttributes(array('class' => 'test'));
    $object->mutateElement(1);
    $this->assertStringStartsWith('test', $object->getObject()->getAttributes()['class']);
    $this->assertEquals(1, count($object->getObject()->getChildren()));
  }

  public function testMutateWithNoAttributes() {
    $object = new ElementIndividual(new Element('div'));
    $object->mutateElement(-10);
    $this->assertNotEquals('test', $object->getObject()->getAttributes()['class']);
    $this->assertEquals(0, count($object->getObject()->getChildren()));
  }
}
