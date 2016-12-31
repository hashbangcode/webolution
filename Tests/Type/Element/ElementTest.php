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

  public function testCloneElement() {
    $element = new Element();
    $element->setType('div');

    $element_clone = clone $element;

    $element_clone->setAttribute('class', 'wibble');

    $this->assertEquals('<div></div>', $element->render());
    $this->assertEquals('<div class="wibble"></div>', $element_clone->render());
  }

  public function testCloneElementWithChild() {
    $outer_element = new Element();
    $outer_element->setType('div');

    $inner_element = new Element();
    $inner_element->setType('div');

    $outer_element->addChild($inner_element);

    $element_clone = clone $outer_element;

    $element_clone->setAttribute('class', 'wibble');

    $element_clone->getChildren()[0]->setAttribute('class', 'wobble');

    $this->assertEquals('<div><div></div></div>', $outer_element->render());
    $this->assertEquals('<div class="wibble"><div class="wobble"></div></div>', $element_clone->render());
  }

  public function testCloneElementWithTwoLevelsChild() {
    $outer_element = new Element('div');
    $inner_element = new Element('div');
    $inner_inner_element = new Element('div');

    $outer_element->addChild($inner_element);
    $inner_element->addChild($inner_inner_element);

    $element_clone = clone $outer_element;

    $element_clone->setAttribute('class', 'wibble');
    $element_clone->getChildren()[0]->setAttribute('class', 'wobble');
    $element_clone->getChildren()[0]->getChildren()[0]->setAttribute('class', 'foo');

    $this->assertEquals('<div><div><div></div></div></div>', $outer_element->render());
    $this->assertEquals('<div class="wibble"><div class="wobble"><div class="foo"></div></div></div>', $element_clone->render());
  }

  public function testSetElementText() {
    $object = new Element();
    $object->setType('div');
    $object->setElementText('sometext');
    $this->assertEquals('div', $object->getType('div'));
    $this->assertEquals('<div>sometext</div>', $object->render());
    $this->assertEquals('sometext', $object->getElementText());
  }

}
