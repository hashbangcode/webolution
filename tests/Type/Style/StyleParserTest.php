<?php

namespace Hashbangcode\Webolution\Test\Type\Style;

use Hashbangcode\Webolution\Type\Style\Style;
use Hashbangcode\Webolution\Type\Style\StyleParser;
use PHPUnit\Framework\TestCase;

/**
 * Test class for StyleParser.
 */
class StyleParserTest extends TestCase
{

  public function testParseStyleIntoObject()
  {
    $style_string = "div.test{background:black;color:red;padding:0px;margin:0px;}";

    $style = StyleParser::parse($style_string);
    $this->assertInstanceOf(Style::class, $style);
    $this->assertEquals('div.test', $style->getSelector());
    $this->assertEquals('black', $style->getAttributes()['background']);
    $this->assertEquals('red', $style->getAttributes()['color']);
    $this->assertEquals('0px', $style->getAttributes()['padding']);
    $this->assertEquals('0px', $style->getAttributes()['margin']);
  }

  public function testParseBlankAttributesCreatesObject()
  {
    $style_string = "div.test{}";

    $style = StyleParser::parse($style_string);
    $this->assertInstanceOf(Style::class, $style);
    $this->assertEquals('div.test', $style->getSelector());
    $this->assertEquals(0, count($style->getAttributes()));
  }

  public function testParseBrokenStyles()
  {
    $style_string = "sdflkasdlfkjasldkf";

    $this->expectException('Hashbangcode\Webolution\Type\Style\Exception\InvalidStyleValueException');
    $style = StyleParser::parse($style_string);
  }
}