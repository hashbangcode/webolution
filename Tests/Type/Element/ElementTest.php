<?php

use Hashbangcode\Wevolution\Type\Element\Element;

/**
 * Test class for Color
 */
class ElementTest extends PHPUnit_Framework_TestCase
{

  public function testCreateObject() {
    $object = new Element();
    $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Element\Element', $object);
  }

  public function testCreateEmptyDivElement() {
    $object = new Element();
    $object->setType('div');
    $this->assertEquals('div', $object->getType('div'));
    $this->assertEquals('<div></div>', $object->render());
  }

  public function testCreateDivElementWithAttribute() {
    $object = new Element();
    $object->setType('div');
    $object->setAttributes(array('id' => 'test'));
    $this->assertEquals('div', $object->getType('div'));
    $this->assertEquals('<div id="test"></div>', $object->render());
  }

  public function testResetAttributes() {
    $object = new Element();
    $object->setType('div');
    $object->setAttributes(array('id' => 'test', 'class' => 'test'));
    $this->assertEquals('test', $object->getAttributes()['id']);
    $this->assertEquals(2, count($object->getAttributes()));
    $object->setAttributes(array('id' => 'another'));
    $this->assertEquals('another', $object->getAttributes()['id']);
    $this->assertEquals(1, count($object->getAttributes()));
  }

  public function testSetSingleAttribute() {
    $object = new Element();
    $object->setType('div');
    $object->setAttribute('id', 'test');
    $this->assertEquals('test', $object->getAttributes()['id']);
    $object->setAttribute('id', 'another');
    $this->assertEquals('another', $object->getAttributes()['id']);
  }

  public function testCreateSinglyNestedDivElement() {
    $outer_element = new Element();
    $outer_element->setType('div');

    $inner_element = new Element();
    $inner_element->setType('div');

    $outer_element->addChild($inner_element);

    $this->assertEquals('div', $outer_element->getType('div'));
    $this->assertEquals('div', $inner_element->getType('div'));
    $this->assertEquals('<div><div></div></div>', $outer_element->render());
  }

  public function testCreateDoublyNestedDivElement() {
    $outer_element = new Element();
    $outer_element->setType('div');

    $inner_element = new Element();
    $inner_element->setType('div');

    $inner_inner_element = new Element();
    $inner_inner_element->setType('div');

    $inner_element->addChild($inner_inner_element);

    $outer_element->addChild($inner_element);

    $this->assertEquals('div', $outer_element->getType('div'));
    $this->assertEquals('div', $inner_element->getType('div'));
    $this->assertEquals('div', $inner_inner_element->getType('div'));
    $this->assertEquals('<div><div><div></div></div></div>', $outer_element->render());
  }

  public function testCreateSinglyNestedDivElementWithMultipleChildren() {
    $outer_element = new Element();
    $outer_element->setType('div');

    $inner_element1 = new Element();
    $inner_element1->setType('div');

    $outer_element->addChild($inner_element1);

    $inner_element2 = new Element();
    $inner_element2->setType('div');

    $outer_element->addChild($inner_element2);

    $this->assertEquals('div', $outer_element->getType('div'));
    $this->assertEquals('div', $inner_element1->getType('div'));
    $this->assertEquals('div', $inner_element2->getType('div'));
    $this->assertEquals('<div><div></div><div></div></div>', $outer_element->render());
  }

  public function testSetIncorrectAttributes() {
    $element = new Element();
    $element->setType('p');
    $this->setExpectedException('Hashbangcode\Wevolution\Type\Element\Exception\InvalidAttributesException');
    $element->setAttributes(2);
  }

  public function testSetChildElement() {
    $element = new Element('ul');
    $child_types = $element->getChildTypes($element->getType());
    $this->assertEquals('li', $child_types[0]);
  }

  public function testMutateElementAttribute() {
    $element = new Element('div');
    $element->setAttributes(array('class' => 'test'));
    $element->mutateElement(-10);
    $this->assertNotEquals('test', $element->getAttributes()['class']);
  }

  public function testMutateElementAttributeLength() {
    $element = new Element('div');
    $element->setAttributes(array('class' => 'test'));
    for ($i = 0; $i < 25; ++$i) {
      $element->mutateElement(-10);
    }
    $this->assertNotEquals('test', $element->getAttributes()['class']);
    $this->assertLessThanOrEqual(10, $element->getAttributes()['class']);
  }

  public function testMutateElementChild() {
    $element = new Element('div');
    $this->assertEquals(0, count($element->getChildren()));
    $element->setAttributes(array('class' => 'test'));
    $element->mutateElement(10);
    $this->assertEquals('test', $element->getAttributes()['class']);
    $this->assertEquals(1, count($element->getChildren()));
  }

  public function testMutateWithNoAttributes() {
    $element = new Element('div');
    $element->mutateElement(-10);
    $this->assertNotEquals('test', $element->getAttributes()['class']);
    $this->assertEquals(0, count($element->getChildren()));
  }
}
