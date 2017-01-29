<?php

use Hashbangcode\Wevolution\Type\Image\Image;

/**
 * Test class for Image
 */
class ImageTest extends PHPUnit_Framework_TestCase
{

  public function testCreateImage() {
    $object = new Image();
    $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Image\Image', $object);
  }
}
