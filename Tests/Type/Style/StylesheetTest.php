<?php

use Hashbangcode\Wevolution\Type\Style\Stylesheet;

/**
 * Test class for Color
 */
class StylesheetTest extends PHPUnit_Framework_TestCase
{

  public function testCreateStyle() {
    $object = new Stylesheet();
    $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Style\Stylesheet', $object);
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
