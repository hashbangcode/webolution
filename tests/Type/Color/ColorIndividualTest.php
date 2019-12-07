<?php

namespace Hashbangcode\Webolution\Test\Type\Color;

use Hashbangcode\Webolution\Type\Color\ColorIndividual;
use PHPUnit\Framework\TestCase;

/**
 * Test class for ColorIndividual
 */
class ColorIndividualTest extends TestCase
{

    public function testGenerateFromHex()
    {
        $object = ColorIndividual::generateFromHex('123456');

        $this->assertEquals(36, strlen($object->getId()));
        $this->assertEquals('123456', $object->getName());
        $this->assertEquals('210', $object->getSpecies());

        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Color\ColorIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Color\Color', $object->getObject());

        $this->assertEquals('123456', $object->getObject()->getHex());
    }

    public function testRenderIndividual()
    {
        $object = ColorIndividual::generateFromRgb(125, 125, 125);
        $object->mutate(0);
        $this->assertEquals('7D7D7D', $object->getObject()->getHex());
    }

    public function testMutateColorThroughIndividual()
    {
        $object = ColorIndividual::generateFromRgb(125, 125, 125);
        $object->mutate(0);
        $this->assertNotEquals('125125125', $object->getObject()->getHex());
    }

    public function testColorFitness()
    {
        $object = ColorIndividual::generateFromRgb(255, 255, 255);
        $this->assertEquals(10, $object->getFitness());

        $object = ColorIndividual::generateFromRgb(125, 125, 125);
        $this->assertEquals(4.902, $object->getFitness());

        $this->assertEquals($object->getObject()->getHue(), $object->getFitness('hue'));
        $this->assertEquals($object->getObject()->getHsvSaturation(), $object->getFitness('saturation'));
        $this->assertEquals($object->getObject()->getValue(), $object->getFitness('value'));
        $this->assertEquals($object->getObject()->getLightness(), $object->getFitness('lightness'));
    }

    public function testColorMutation()
    {
        $object = ColorIndividual::generateFromRgb(125, 125, 125);
        $object->mutate(0, 100);

        $this->assertGreaterThanOrEqual(0, $object->getObject()->getRed());
        $this->assertLessThanOrEqual(255, $object->getObject()->getRed());
    }

    public function testColorMutationLowerRange()
    {
        $object = ColorIndividual::generateFromRgb(0, 0, 0);
        $object->mutate(0, 100);

        $this->assertGreaterThanOrEqual(0, $object->getObject()->getRed());
        $this->assertLessThanOrEqual(255, $object->getObject()->getRed());
    }

    public function testColorMutationUpperRange()
    {
        $object = ColorIndividual::generateFromRgb(255, 255, 255);
        $object->mutate(0, 100);

        $this->assertGreaterThanOrEqual(0, $object->getObject()->getRed());
        $this->assertLessThanOrEqual(255, $object->getObject()->getRed());
    }

    public function testLargeColorMutation()
    {
        $object = ColorIndividual::generateFromRgb(0, 0, 0);
        for ($i = 0; $i < 100; ++$i) {
            $object->mutate(0, 100);

            $this->assertGreaterThanOrEqual(0, $object->getObject()->getRed());
            $this->assertLessThanOrEqual(255, $object->getObject()->getRed());

            $this->assertGreaterThanOrEqual(0, $object->getObject()->getGreen());
            $this->assertLessThanOrEqual(255, $object->getObject()->getGreen());

            $this->assertGreaterThanOrEqual(0, $object->getObject()->getBlue());
            $this->assertLessThanOrEqual(255, $object->getObject()->getBlue());
        }
    }

}
