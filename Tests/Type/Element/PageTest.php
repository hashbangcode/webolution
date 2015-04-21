<?php

use Hashbangcode\Wevolution\Type\Element\Page;
use Hashbangcode\Wevolution\Type\Element\Element;

/**
 * Test class for Color
 */
class PageTest extends PHPUnit_Framework_TestCase
{

  public function testCreateObject() {
    $element = new Element();
    $element->setType('html');
    $object = new Page($element);
    $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Element\Page', $object);
  }

  public function testMinimalPageRender() {
    $element = new Element();
    $element->setType('html');
    $page = new Page($element);
    $this->assertEquals('<html></html>', $page->render());
  }

  public function testPageRender() {
    $element = new Element();
    $element->setType('html');
    $page = new Page($element);

    $page->getRootElement()->addChild(new Element('head'));
    $page->getRootElement()->addChild(new Element('body'));

    $this->assertEquals('<html><head></head><body></body></html>', $page->render());
  }

}
