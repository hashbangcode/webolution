<?php

use Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual;

/**
 * Test class for ColorIndividual
 */
class StyleIndividualTest extends PHPUnit_Framework_TestCase
{

  public function testCreateNumberIndividual() {
    $object = new StyleIndividual(1);
    $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual', $object);
    $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Style\Style', $object->getObject());
  }

}
