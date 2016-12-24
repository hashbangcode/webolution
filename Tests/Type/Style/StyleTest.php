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

  public function testSetAndGetAttributes() {
    $object = new Style('.element');
    $object->setAttributes(['background' => 'black']);
    $attributes = $object->getAttributes();
    $this->assertEquals('black', $attributes['background']);
  }

  public function testFullObjectCreation() {
    $object = new Style('.element', ['background' => 'black']);
    $attributes = $object->getAttributes();
    $this->assertEquals('black', $attributes['background']);
  }

  public function testRenderSimpleStyle() {
    $object = new Style('.element', ['background' => 'black']);
    $renderedStyle = $object->render();
    $this->assertEquals('.element{background:black;}', $renderedStyle);
  }

  public function testChangeSelector() {
    $object = new Style('.element', ['background' => 'black']);
    $object->setSelector('.div');
    $this->assertEquals('.div', $object->getSelector());
  }

  public function testGetAttribute() {
    $object = new Style('.element', ['background' => 'black']);
    $this->assertEquals('black', $object->getAttrbute('background'));
  }

  public function testGetNonExistingAttribute() {
    $object = new Style('.element', ['background' => 'black']);
    $this->assertEquals(false, $object->getAttrbute('color'));
  }

  public function testRenderMoreComplexStyle() {
    $object = new Style('.element', ['background' => 'black']);
    $object->setAttrbute('color', 'red');
    $object->setAttrbute('padding', '0px');
    $renderedStyle = $object->render();
    $this->assertEquals('.element{background:black;color:red;padding:0px;}', $renderedStyle);
  }
}
