<?php

use Hashbangcode\Wevolution\Type\Style\Style;
use Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual;

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
    $this->assertEquals('black', $object->getAttribute('background'));
  }

  public function testGetNonExistingAttribute() {
    $object = new Style('.element', ['background' => 'black']);
    $this->assertEquals(false, $object->getAttribute('color'));
  }

  public function testRenderMoreComplexStyle() {
    $object = new Style('.element', ['background' => 'black']);
    $object->setAttrbute('color', 'red');
    $object->setAttrbute('padding', '0px');
    $renderedStyle = $object->render();
    $this->assertEquals('.element{background:black;color:red;padding:0px;}', $renderedStyle);
  }

  public function testRenderStyleWithObjectAttribute() {
    $object = new Style('.element');
    $object->setAttrbute('background', ColorIndividual::generateFromHex('000000'));
    $object->setAttrbute('color', ColorIndividual::generateFromHex('555555'));
    $object->setAttrbute('padding', '0px');
    $renderedStyle = $object->render();
    $this->assertEquals('.element{background:#000000;color:#555555;padding:0px;}', $renderedStyle);
  }

  public function testCloneStyleObject() {
    $object = new Style('.element');
    $object->setAttrbute('background', ColorIndividual::generateFromHex('000000'));
    $object->setAttrbute('color', ColorIndividual::generateFromHex('555555'));
    $object->setAttrbute('padding', '0px');

    $new_object = clone $object;

    $color = $new_object->getAttribute('color');
    $color->getObject()->setRed('000');

    // Original object should have the same attributes.
    $renderedStyle = $object->render();
    $this->assertEquals('.element{background:#000000;color:#555555;padding:0px;}', $renderedStyle);

    // New object should have new color.
    $newRenderedStyle = $new_object->render();
    $this->assertEquals('.element{background:#000000;color:#005555;padding:0px;}', $newRenderedStyle);
  }
}
