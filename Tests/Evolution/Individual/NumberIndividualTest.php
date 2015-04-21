<?php

use Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual;

/**
 * Test class for ColorIndividual
 */
class NumberIndividualTest extends PHPUnit_Framework_TestCase
{

  public function testCreateNumberIndividual() {
    $object = new NumberIndividual(1);
    $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual', $object);
    $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Number\Number', $object->getObject());
  }

  public function testMutateNumberThroughIndividual() {
    $object = new NumberIndividual(1);
    $object->mutateProperties();
    $this->assertNotEquals(1, $object->getObject()->getNumber());
  }
}
