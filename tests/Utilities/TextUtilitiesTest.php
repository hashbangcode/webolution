<?php

use Hashbangcode\Wevolution\Utilities\TextUtilities;

/**
 * Test class for Color
 */
class TextUtilitiesTest extends PHPUnit_Framework_TestCase
{
  use TextUtilities;

  public function testCreateLetter() {
    $letter = $this->getRandomLetter();
    $this->assertTrue(is_string($letter));
    $this->assertEquals(1, strlen($letter));
  }

  public function testCreateText() {
    $letter = $this->generateRandomText();
    $this->assertTrue(is_string($letter));
    $this->assertEquals(7, strlen($letter));
  }
}
