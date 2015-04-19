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
    $object->mutateProperties();
    $this->assertNotEquals('125125125', $object->getObject()->getRGB());
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
