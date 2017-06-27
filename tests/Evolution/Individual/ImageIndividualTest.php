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
        $object = new ImageIndividual();
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
        $object = new ImageIndividual();
        $fitness = $object->getFitness();
        $this->assertEquals(0, $fitness);
    }

    public function testFitnessOfBlankImageAsHeight()
    {
        $object = new ImageIndividual();
        $fitness = $object->getFitness('height');
        $this->assertEquals(0, $fitness);
    }

    public function testMutateImageThroughIndividual()
    {
        $object = new ImageIndividual();

        $render = $object->getObject()->render();
        $this->assertNotRegExp('/1/', $render);

        $object->mutate(-100);

        $render = $object->getObject()->render();
        $this->assertRegexp('/1/', $render);
    }
}
