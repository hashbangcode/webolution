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
}
