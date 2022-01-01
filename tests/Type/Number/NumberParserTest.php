<?php

namespace Hashbangcode\Webolution\Test\Type\Number;

use Hashbangcode\Webolution\Type\Number\Number;
use Hashbangcode\Webolution\Type\Number\NumberParser;
use PHPUnit\Framework\TestCase;

/**
 * Test class for NumberParser.
 */
class NumberParserTest extends TestCase
{

  public function testParseNumberIntoObject()
  {
    $number = NumberParser::parse('1');
    $this->assertInstanceOf(Number::class, $number);
    $this->assertEquals(1, $number->getNumber());

    $number = NumberParser::parse('2');
    $this->assertInstanceOf(Number::class, $number);
    $this->assertEquals(2, $number->getNumber());
  }

  public function testParseInvalidNumber()
  {
    $this->expectException('Hashbangcode\Webolution\Type\Number\Exception\InvalidNumberException');
    $number = NumberParser::parse('apple');
  }
}