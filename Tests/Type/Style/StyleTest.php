<?php

use Hashbangcode\Wevolution\Type\Style\Style;

/**
 * Test class for Color
 */
class StyleTest extends PHPUnit_Framework_TestCase
{

  public function testCreateStyle() {
    $object = new Style('.element');
    $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Style\Style', $object);
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
