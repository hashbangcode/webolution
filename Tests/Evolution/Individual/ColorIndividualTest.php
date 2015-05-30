<?php

use Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual;

/**
 * Test class for ColorIndividual
 */
class ColorIndividualTest extends PHPUnit_Framework_TestCase
{

  public function testCreateColorIndividual() {
    $object = new ColorIndividual(0, 0, 0);
    $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual', $object);
    $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Color\Color', $object->getObject());
  }

  public function testMutateColorThroughIndividual() {
    $object = new ColorIndividual(125, 125, 125);
    $object->setMutationFactor(1);
    $object->mutateProperties();
    $this->assertNotEquals('125125125', $object->getObject()->render());
    $this->assertNotEquals('125125125', $object->render());
  }

  public function testColorFitness() {
    $object = new ColorIndividual(255, 255, 255);
    $this->assertEquals(10, $object->getFitness());

    $object = new ColorIndividual(125, 125, 125);
    $this->assertEquals(5, $object->getFitness());
  }

}
