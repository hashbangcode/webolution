<?php

namespace Hashbangcode\Webolution\Test\Evolution\Individual;

use Hashbangcode\Webolution\Evolution\Individual\ColorIndividual;

/**
 * Test class for ColorIndividual
 */
class ColorIndividualTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateIndividual()
    {
        $object = ColorIndividual::generateFromRgb(0, 0, 0);
        $this->assertInstanceOf('Hashbangcode\Webolution\Evolution\Individual\ColorIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Color\Color', $object->getObject());
    }

    public function testGenerateFromHex()
    {
        $object = ColorIndividual::generateFromHex('123456');
        $this->assertInstanceOf('Hashbangcode\Webolution\Evolution\Individual\ColorIndividual', $object);
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
