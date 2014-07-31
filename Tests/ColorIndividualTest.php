<?php

require_once '../includes/Color.php';
require_once '../includes/ColorIndividual.php';

/**
 * Test class for Color
 */
class ColorIndividualTest extends PHPUnit_Framework_TestCase
{

  public function testCreateColorIndividual() {
    $object = new ColorIndividual();
    $this->assertInstanceOf('ColorIndividual', $object);
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
