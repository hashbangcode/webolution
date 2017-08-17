<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Population\ImagePopulation;
use Hashbangcode\Wevolution\Evolution\Individual\ImageIndividual;
use Hashbangcode\Wevolution\Type\Image\Image;

class ImagePopulationTest extends \PHPUnit_Framework_TestCase
{

    public function testEmptyColorPopulation()
    {
        $object = new ImagePopulation();
        $this->assertEquals(0, $object->getLength());
    }

    public function testAddItemColorPopulation()
    {
        $object = new ImagePopulation();
        $object->addIndividual();
        $this->assertEquals(1, $object->getLength());
    }

    public function testAddItemsToColorPopulation()
    {
        $object = new ImagePopulation();

        $object->addIndividual();
        $object->addIndividual();
        $object->addIndividual();

        $this->assertEquals(3, $object->getLength());
    }

    public function testSortPopulation()
    {
        $object = new ImagePopulation();

        // Create first iamge.
        $image1 = ImageIndividual::generateFromImageSize(10, 10);
        $image1->getObject()->setPixel(9, 5, 1);
        $image1->getObject()->setPixel(8, 5, 1);
        $image1->getObject()->setPixel(7, 5, 1);
        $image1->getObject()->setPixel(6, 5, 1);
        $image1->getObject()->setPixel(5, 5, 1);
        $image1->getObject()->setPixel(4, 5, 1);
        $object->addIndividual($image1);

        // Create second image.
        $image2 = ImageIndividual::generateFromImageSize(10, 10);
        $image2->getObject()->setPixel(9, 5, 1);
        $image2->getObject()->setPixel(8, 5, 1);
        $image2->getObject()->setPixel(7, 5, 1);
        $object->addIndividual($image2);

        // Create third iamge.
        $image3 = ImageIndividual::generateFromImageSize(10, 10);
        $image3->getObject()->setPixel(9, 5, 1);
        $image3->getObject()->setPixel(8, 5, 1);
        $object->addIndividual($image3);

        // Create fourth image.
        $image4 = ImageIndividual::generateFromImageSize(10, 10);
        $image4->getObject()->setPixel(9, 5, 1);
        $image4->getObject()->setPixel(8, 5, 1);
        $image4->getObject()->setPixel(7, 5, 1);
        $image4->getObject()->setPixel(6, 5, 1);
        $image4->getObject()->setPixel(5, 5, 1);
        $object->addIndividual($image4);

        // Create fifth iamge.
        $image5 = ImageIndividual::generateFromImageSize(10, 10);
        $image5->getObject()->setPixel(9, 5, 1);
        $object->addIndividual($image5);

        // Create sixth iamge.
        $image6 = ImageIndividual::generateFromImageSize(10, 10);
        $image6->getObject()->setPixel(9, 2, 1);
        $image6->getObject()->setPixel(8, 2, 1);
        $image6->getObject()->setPixel(7, 2, 1);
        $object->addIndividual($image6);
        
        $this->assertEquals(6, $object->getLength());

        $object->sort();

        $images = $object->getIndividuals();
        $this->assertEquals(1, $images[0]->getObject()->getHeight());
        $this->assertEquals(2, $images[1]->getObject()->getHeight());
        $this->assertEquals(3, $images[2]->getObject()->getHeight());
        $this->assertEquals(3, $images[3]->getObject()->getHeight());
        $this->assertEquals(5, $images[4]->getObject()->getHeight());
        $this->assertEquals(6, $images[5]->getObject()->getHeight());

        $object->sort('DESC');

        $images = $object->getIndividuals();
        $this->assertEquals(6, $images[0]->getObject()->getHeight());
        $this->assertEquals(5, $images[1]->getObject()->getHeight());
        $this->assertEquals(3, $images[2]->getObject()->getHeight());
        $this->assertEquals(3, $images[3]->getObject()->getHeight());
        $this->assertEquals(2, $images[4]->getObject()->getHeight());
        $this->assertEquals(1, $images[5]->getObject()->getHeight());
    }
}
