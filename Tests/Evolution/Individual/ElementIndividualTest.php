<?php

use Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual;

/**
 * Test class for ColorIndividual
 */
class ElementIndividualTest extends PHPUnit_Framework_TestCase
{

  public function testCreateElementIndividual() {
    $object = new ElementIndividual(1);
    $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual', $object);
    $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Element\Element', $object->getObject());
  }

  public function testMutateElementThroughIndividual() {
    $object = new ElementIndividual('div');
    $object->mutateProperties();
    $this->assertEquals('div', $object->getObject()->getType());
  }

  public function testMutateElementThroughIndividualWithDifferentFactor() {
    $object = new ElementIndividual('div');
    $object->setMutationFactor(-10);
    $object->mutateProperties();
    $this->assertEquals('div', $object->getObject()->getType());
    $this->assertEquals(-10, $object->getMutationFactor());
  }

  public function testGetElementIndividualFitness() {
    $object = new ElementIndividual('div');
    $this->assertEquals(1, $object->getFitness());
    $object->getObject()->setType('p');
    $this->assertEquals(1, $object->getFitness());
  }

  public function testElementIndividualRender() {
    $object = new ElementIndividual('html');
    $renderType = 'cli';
    $this->assertEquals('<html></html>', $object->render($renderType));
  }
}
