<?php

namespace Hashbangcode\Webolution\Test\Type\Element;

use Hashbangcode\Webolution\Type\Element\Element;
use Hashbangcode\Webolution\Type\Element\ElementParser;
use PHPUnit\Framework\TestCase;

/**
 * Test class for ElementParser.
 */
class ElementParserTest extends TestCase
{

  public function testParseElementStringIntoObject()
  {
    $element = ElementParser::parse('<div></div>');
    $this->assertInstanceOf(Element::class, $element);
    $this->assertEquals('div', $element->getType());
  }

  public function testParseElementWithClassStringIntoObject()
  {
    $element = ElementParser::parse('<div class="test">Test</div>');
    $this->assertInstanceOf(Element::class, $element);
    $this->assertEquals('div', $element->getType());
    $this->assertEquals('test', $element->getAttributes()['class']);
    $this->assertEquals('Test', $element->getElementText());
  }

  public function testParseElementWithNestedElementIntoObject()
  {
    $element = ElementParser::parse('<div class="test"><p>Test</p></div>');
    $this->assertInstanceOf(Element::class, $element);
    $this->assertEquals('div', $element->getType());
    $this->assertEquals('test', $element->getAttributes()['class']);
    $this->assertEquals(NULL, $element->getElementText());

    $children = $element->getChildren();
    $this->assertEquals('p', $children[0]->getType());
    $this->assertEquals('Test', $children[0]->getElementText());
  }

  public function testParseElementWithDoublyNestedElementIntoObject()
  {
    $element = ElementParser::parse('<div class="test"><p>Test</p><p>Testing</p></div>');
    $this->assertInstanceOf(Element::class, $element);
    $this->assertEquals('div', $element->getType());
    $this->assertEquals('test', $element->getAttributes()['class']);
    $this->assertEquals(NULL, $element->getElementText());

    $children = $element->getChildren();
    $this->assertEquals('p', $children[0]->getType());
    $this->assertEquals('Test', $children[0]->getElementText());

    $this->assertEquals('p', $children[0]->getType());
    $this->assertEquals('Testing', $children[1]->getElementText());
  }
}