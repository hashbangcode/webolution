<?php

namespace Hashbangcode\Webolution\Test\Type\Style;

use Hashbangcode\Webolution\Type\Style\Style;
use Hashbangcode\Webolution\Evolution\Individual\ColorIndividual;

/**
 * Test class for Color
 */
class StyleTest extends \PHPUnit_Framework_TestCase
{
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

    public function testCloneStyleObject()
    {
        $object = new Style('.element');

        $object->setAttribute('color', ColorIndividual::generateFromHex('555555'));
        $object->setAttribute('padding', '0px');

        $newObject = clone $object;

        $color = $newObject->getAttribute('color');
        $color->getObject()->setRed('000');

        // Original object should have the same color.
        $this->assertEquals('555555', $object->getAttribute('color')->getObject()->getHex());
        $this->assertEquals('005555', $newObject->getAttribute('color')->getObject()->getHex());
    }
}
