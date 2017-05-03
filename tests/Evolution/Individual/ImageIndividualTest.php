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

    public function testMutateImageThroughIndividual()
    {
        $object = new ImageIndividual();

        $render = $object->getObject()->render();
        $this->assertNotRegExp('/1/', $render);

        $object->setMutationFactor(-100);
        $object->mutate(-100);

        $render = $object->getObject()->render();
        $this->assertRegexp('/1/', $render);
    }
}
