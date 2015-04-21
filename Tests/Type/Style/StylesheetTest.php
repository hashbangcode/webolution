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
}
