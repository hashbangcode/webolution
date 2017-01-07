<?php

use Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual;
use Hashbangcode\Wevolution\Type\Element\Element;

/**
 * Test class for ColorIndividual
 */
class ElementIndividualTest extends PHPUnit_Framework_TestCase
{

  public function testCreateIndividual() {
    $object = new ElementIndividual(new Element('div'));
    $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual', $object);
    $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Element\Element', $object->getObject());
  }

  public function testMutateElementThroughIndividual() {
    $html = new Element('html');
    $body = new Element('body');
    $html->addChild($body);

    $object = new ElementIndividual($html);

    $object->mutateProperties();
    $this->assertEquals('html', $object->getObject()->getType());
  }

  public function testMutateElementThroughIndividualWithDifferentFactor() {

    $html = new Element('html');
    $body = new Element('body');
    $html->addChild($body);

    $object = new ElementIndividual($html);

    $object->setMutationFactor(-10);
    $object->mutateProperties();
    $this->assertEquals('html', $object->getObject()->getType());

    $this->assertEquals(-10, $object->getMutationFactor());
  }

  public function testGetElementIndividualFitness() {
    $object = new ElementIndividual(new Element('div'));
    $this->assertEquals(1, $object->getFitness());
    $object->getObject()->setType('p');
    $this->assertEquals(1, $object->getFitness());
  }

  public function testElementIndividualCliRenderWithObject() {
    $object = new ElementIndividual(new Element('html'));
    $renderType = 'cli';
    $this->assertEquals('<html></html>' . PHP_EOL, $object->render($renderType));
  }

  public function testElementIndividualCliRenderWithString() {
    $object = new ElementIndividual('html');
    $renderType = 'cli';
    $this->assertEquals('<html></html>' . PHP_EOL, $object->render($renderType));
  }

  public function testElementIndividualHtmlRenderWithObject() {
    $object = new ElementIndividual(new Element('html'));
    $renderType = 'html';
    $this->assertEquals('<html></html>', $object->render($renderType));
  }

  public function testElementIndividualHtmlRenderWithString() {
    $object = new ElementIndividual('html');
    $renderType = 'html';
    $this->assertEquals('<html></html>', $object->render($renderType));
  }

  public function testMutateElementAttribute() {
    $html = new Element('html');
    $body = new Element('body');
    $html->addChild($body);

    $object = new ElementIndividual($html);

    $rootElement = $object->getObject();
    $element = $rootElement->getChildren()[0];
    $element->setAttributes(array('class' => 'test'));

    $object->mutateElement(-10);
    $this->assertContains('<html><body class="test"><', $object->render());
  }

  public function testMutateElementAttributeLength() {
    $html = new Element('html');
    $body = new Element('body');
    $html->addChild($body);

    $object = new ElementIndividual($html);

    $rootElement = $object->getObject();
    $element = $rootElement->getChildren()[0];
    $element->setAttributes(array('class' => 'test'));

    for ($i = 0; $i < 25; ++$i) {
      $object->mutateElement(-10);
    }

    $this->assertLessThanOrEqual(10, $object->getObject()->getAttributes()['class']);
  }

  public function testMutateElementChild() {
    $html = new Element('html');
    $body = new Element('body');
    $html->addChild($body);

    $object = new ElementIndividual($html);

    $this->assertEquals(1, count($object->getObject()->getChildren()));

    $object->getObject()->setAttributes(array('class' => 'test'));
    $object->mutateElement(1);
    $this->assertStringStartsWith('test', $object->getObject()->getAttributes()['class']);

    $this->assertEquals(1, count($object->getObject()->getChildren()));
  }

  public function testMutateWithNoAttributes() {
    $html = new Element('html');
    $body = new Element('body');
    $html->addChild($body);

    $object = new ElementIndividual($html);

    $object->mutateElement(-10);
    $this->assertNotEquals('test', $object->getObject()->getAttributes()['class']);
    $this->assertEquals(1, count($object->getObject()->getChildren()));
  }
}
