<?php

namespace Hashbangcode\Webolution\Test\Type\Image;

use Hashbangcode\Webolution\Type\Image\ImageIndividual;
use PHPUnit\Framework\TestCase;

/**
 * Test class for ColorIndividual
 */
class ImageIndividualTest extends TestCase
{

    public function testCreateIndividual()
    {
        $object = ImageIndividual::generateRandomImage();
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Image\ImageIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Image\Image', $object->getObject());
    }

    public function testCreateRandomIndividual()
    {
        $object = ImageIndividual::generateRandomImage();
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Image\ImageIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Image\Image', $object->getObject());
    }

    public function testFitnessOfBlankImage()
    {
        $object = ImageIndividual::generateRandomImage();
        $fitness = $object->getFitness();
        $this->assertEquals(0, $fitness);
    }

    public function testFitnessOfBlankImageAsHeight()
    {
        $object = ImageIndividual::generateRandomImage();
        $fitness = $object->getFitness('height');
        $this->assertEquals(0, $fitness);
    }
}
