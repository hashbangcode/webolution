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

  /**
   * Sets up the fixture, for example, opens a network connection.
   * This method is called before a test is executed.
   */
  protected function setUp()
  {

  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown()
  {

  }

}
