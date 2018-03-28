<?php

namespace Hashbangcode\Wevolution\Test\Type\Style;

use Hashbangcode\Wevolution\Evolution\Individual\UnitIndividual;
use Hashbangcode\Wevolution\Type\Style\Style;
use Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual;

/**
 * Test class for Color
 */
class StyleTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateStyle()
    {
        $object = new Style('.element');
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Style\Style', $object);
    }

    public function testSetAndGetAttributes()
    {
        $object = new Style('.element');
        $object->setAttributes(['background' => 'black']);
        $attributes = $object->getAttributes();
        $this->assertEquals('black', $attributes['background']);
    }

    public function testFullObjectCreation()
    {
        $object = new Style('.element', ['background' => 'black']);
        $attributes = $object->getAttributes();
        $this->assertEquals('black', $attributes['background']);
    }

    public function testRenderSimpleStyle()
    {
        $object = new Style('.element', ['background' => 'black']);
        $renderedStyle = $object->render();
        $this->assertEquals('.element{background:black;}', $renderedStyle);
    }

    public function testChangeSelector()
    {
        $object = new Style('.element', ['background' => 'black']);
        $object->setSelector('.div');
        $this->assertEquals('.div', $object->getSelector());
    }

    public function testGetAttribute()
    {
        $object = new Style('.element', ['background' => 'black']);
        $this->assertEquals('black', $object->getAttribute('background'));
    }

    public function testGetNonExistingAttribute()
    {
        $object = new Style('.element', ['background' => 'black']);
        $this->assertEquals(false, $object->getAttribute('color'));
    }

    public function __testRenderArrayStyle()
    {
      // @todo : refactor into decorator.
      // @todo : refactor using phophecy.
        $units = [
            UnitIndividual::generateFromUnitArguments(1, 'px'),
            UnitIndividual::generateFromUnitArguments(1, 'px'),
            UnitIndividual::generateFromUnitArguments(1, 'px'),
            UnitIndividual::generateFromUnitArguments(1, 'px'),
        ];

        $object = new Style('.element', ['margin' => $units]);
        $renderedStyle = $object->render();
        $this->assertEquals('.element{margin:1px 1px 1px 1px;}', $renderedStyle);
    }

    public function __testRenderStyleWithObjectAttribute()
    {
        $object = new Style('.element');
        // @todo : refactor using phophecy.
        $object->setAttribute('background', ColorIndividual::generateFromHex('000000'));
        $object->setAttribute('color', ColorIndividual::generateFromHex('555555'));
        $object->setAttribute('padding', '0px');

        $this->assertEquals('.element', $object->getSelector());
        $this->assertEquals('000000', $object->getAttribute('background')->getObject()->getHex());
        $this->assertEquals('555555', $object->getAttribute('color')->getObject()->getHex());
        $this->assertEquals('0px', $object->getAttribute('padding'));
    }

    public function testCloneStyleObject()
    {
        $object = new Style('.element');
        // @todo : refactor using phophecy.
        $object->setAttribute('background', ColorIndividual::generateFromHex('000000'));
        $object->setAttribute('color', ColorIndividual::generateFromHex('555555'));
        $object->setAttribute('padding', '0px');

        $new_object = clone $object;

        $color = $new_object->getAttribute('color');
        $color->getObject()->setRed('000');

        // Original object should have the same color.
        $this->assertEquals('555555', $object->getAttribute('color')->getObject()->getHex());
        $this->assertEquals('005555', $new_object->getAttribute('color')->getObject()->getHex());
    }
}
