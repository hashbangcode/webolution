<?php

namespace Hashbangcode\Webolution\Test\Type\Color;

use Hashbangcode\Webolution\Type\Color\Color;
use Hashbangcode\Webolution\Type\Color\ColorParser;
use PHPUnit\Framework\TestCase;

/**
 * Test class for ColorParser.
 */
class ColorParserTest extends TestCase
{

  public function testParseColorIntoObject()
  {
    $color = ColorParser::parse('#000000');
    $this->assertInstanceOf(Color::class, $color);
    $this->assertEquals(0, $color->getRed());
    $this->assertEquals(0, $color->getGreen());
    $this->assertEquals(0, $color->getBlue());

    $color = ColorParser::parse('#ffffff');
    $this->assertInstanceOf(Color::class, $color);
    $this->assertEquals(255, $color->getRed());
    $this->assertEquals(255, $color->getGreen());
    $this->assertEquals(255, $color->getBlue());
  }
}