<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual;

use Hashbangcode\Wevolution\Evolution\Individual\ImageIndividual;

/**
 * Test class for ColorIndividual
 */
class ImageIndividualTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateIndividual()
    {
        $object = ImageIndividual::generateRandomImage();
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\ImageIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Image\Image', $object->getObject());
    }

    public function testCreateRandomIndividual()
    {
        $object = ImageIndividual::generateRandomImage();
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\ImageIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Image\Image', $object->getObject());
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
