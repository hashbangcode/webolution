<?php

namespace Hashbangcode\Webolution\Test\Type\Page;

use Hashbangcode\Webolution\Type\Page\Page;
use Hashbangcode\Webolution\Type\Page\PageIndividual;
use Hashbangcode\Webolution\Type\Page\PageParser;
use PHPUnit\Framework\TestCase;

use Hashbangcode\Webolution\Type\Page\Decorator\PageIndividualDecoratorHtml;
use Hashbangcode\Webolution\Type\Element\Element;
use Hashbangcode\Webolution\Type\Color\ColorIndividual;
use Hashbangcode\Webolution\Type\Style\Style;

/**
 * Test class for PageParser.
 */
class PageParserTest extends TestCase
{

  public function testParsePageIntoObject()
  {
      $page = PageParser::parse('<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <style>
        div{color:red;}
    </style>
</head>
<body>
<div></div>
</body>
</html>');
        $this->assertInstanceOf(Page::class, $page);
        $this->assertEquals(1, count($page->getStyles()));
        $this->assertEquals('red', $page->getStyles()['div']->getAttribute('color'));
        $this->assertEquals('div', $page->getBody()->getType());
    }

    public function testParseMoreComplexPageIntoObject()
    {
        $page = PageParser::parse('<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <style>
        div p{margin:0px;color:black;}
        p.testclass{background:black;color:red;padding:0px;margin:0px;}
    </style>
</head>
<body>
<div>
    <p>Testing</p>
    <p class="testclass">More content</p>
</div>
</body>
</html>');
        $this->assertInstanceOf(Page::class, $page);
        $this->assertEquals(2, count($page->getStyles()));
        $this->assertEquals('black', $page->getStyles()['div p']->getAttribute('color'));
        $this->assertEquals('black', $page->getStyles()['p.testclass']->getAttribute('background'));
        $this->assertEquals('div', $page->getBody()->getType());
    }

    public function testPageCreationWithBodyAndStyleWithColorObject()
    {
        $body = new Element('div');
        $body->setAttribute('class', 'test');

        $color = ColorIndividual::generateFromHex('2CA02C');

        $style = new Style('div.test', ['color' => $color]);

        $page = new Page();
        $page->setBody($body);
        $page->setStyles([$style]);

        $individual = new PageIndividual($page);

        $individualDecorator = new PageIndividualDecoratorHtml($individual);
        $output = $individualDecorator->render();

        $page = PageParser::parse($output);

        $this->assertInstanceOf(Page::class, $page);
        $this->assertEquals(1, count($page->getStyles()));
        $this->assertEquals('#2CA02C', $page->getStyles()['div.test']->getAttribute('color'));
        $this->assertEquals('div', $page->getBody()->getType());
    }
}