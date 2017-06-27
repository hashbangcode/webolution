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

    public function testRenderImageIndividualAsImage()
    {
        $object = new ImageIndividual(25, 25);
        $object->getObject()->setPixel(24, 12, 1);
        $imageOutput = $object->render('image');
        $this->assertContains('width="125"', $imageOutput);
        $this->assertContains('height="125"', $imageOutput);
    }

    public function testRenderImageIndividualAsHtml()
    {
        $object = new ImageIndividual(25, 25);
        $object->getObject()->setPixel(24, 12, 1);
        $htmlOutput = $object->render('html');
        $this->assertContains('<p>', $htmlOutput);
        $this->assertContains('0001000', $htmlOutput);
    }

    public function testRenderImageIndividualAsDefault()
    {
        $object = new ImageIndividual(25, 25);
        $object->getObject()->setPixel(24, 12, 1);
        $defaultOutput = $object->render();
        $this->assertNotContains('<p>', $defaultOutput);
        $this->assertContains('0001000', $defaultOutput);
    }

    public function testRenderImageIndividualAsCli()
    {
        $object = new ImageIndividual(25, 25);
        $object->getObject()->setPixel(24, 12, 1);
        $defaultOutput = $object->render('cli');
        $this->assertNotContains('<p>', $defaultOutput);
        $this->assertContains('0001000', $defaultOutput);
    }
}
