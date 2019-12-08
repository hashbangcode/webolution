<?php

namespace Hashbangcode\Webolution\Test\Type\Image;

use Hashbangcode\Webolution\Type\Image\ImagePopulation;
use Hashbangcode\Webolution\Type\Image\ImageIndividual;
use Hashbangcode\Webolution\Type\Image\Image;
use PHPUnit\Framework\TestCase;

class ImagePopulationTest extends TestCase
{

    public function testEmptyColorPopulation()
    {
        $object = new ImagePopulation();
        $this->assertEquals(0, $object->getIndividualCount());
    }

    public function testAddItemColorPopulation()
    {
        $object = new ImagePopulation();
        $object->addIndividual();
        $this->assertEquals(1, $object->getIndividualCount());
    }

    public function testAddItemsToColorPopulation()
    {
        $object = new ImagePopulation();

        $object->addIndividual();
        $object->addIndividual();
        $object->addIndividual();

        $this->assertEquals(3, $object->getIndividualCount());
    }

    public function testSortPopulation()
    {
        $object = new ImagePopulation();

        // Create first image (height is 6).
        $image1 = ImageIndividual::generateFromImageSize(10, 10);
        $image1->getObject()->setPixel(9, 5, 1);
        $image1->getObject()->setPixel(8, 5, 1);
        $image1->getObject()->setPixel(7, 5, 1);
        $image1->getObject()->setPixel(6, 5, 1);
        $image1->getObject()->setPixel(5, 5, 1);
        $image1->getObject()->setPixel(4, 5, 1);
        $object->addIndividual($image1);

        // Create second image (height is 3).
        $image2 = ImageIndividual::generateFromImageSize(10, 10);
        $image2->getObject()->setPixel(9, 5, 1);
        $image2->getObject()->setPixel(8, 5, 1);
        $image2->getObject()->setPixel(7, 5, 1);
        $object->addIndividual($image2);

        // Create third image (height is 2).
        $image3 = ImageIndividual::generateFromImageSize(10, 10);
        $image3->getObject()->setPixel(9, 5, 1);
        $image3->getObject()->setPixel(8, 5, 1);
        $object->addIndividual($image3);

        // Create fourth image (height is 5).
        $image4 = ImageIndividual::generateFromImageSize(10, 10);
        $image4->getObject()->setPixel(9, 5, 1);
        $image4->getObject()->setPixel(8, 5, 1);
        $image4->getObject()->setPixel(7, 5, 1);
        $image4->getObject()->setPixel(6, 5, 1);
        $image4->getObject()->setPixel(5, 5, 1);
        $object->addIndividual($image4);

        // Create fifth image (height is 1).
        $image5 = ImageIndividual::generateFromImageSize(10, 10);
        $image5->getObject()->setPixel(9, 5, 1);
        $object->addIndividual($image5);

        // Create sixth image (height is 4).
        $image6 = ImageIndividual::generateFromImageSize(10, 10);
        $image6->getObject()->setPixel(9, 2, 1);
        $image6->getObject()->setPixel(8, 2, 1);
        $image6->getObject()->setPixel(7, 2, 1);
        $image6->getObject()->setPixel(6, 2, 1);
        $object->addIndividual($image6);
        
        $this->assertEquals(6, $object->getIndividualCount());

        $object->sort();

        // Ensure that the keys are still in the same locations.
        $images = $object->getIndividuals();
        $this->assertEquals(6, $images[0]->getObject()->getPixelHeightFromBottom());
        $this->assertEquals(3, $images[1]->getObject()->getPixelHeightFromBottom());
        $this->assertEquals(2, $images[2]->getObject()->getPixelHeightFromBottom());
        $this->assertEquals(5, $images[3]->getObject()->getPixelHeightFromBottom());
        $this->assertEquals(1, $images[4]->getObject()->getPixelHeightFromBottom());
        $this->assertEquals(4, $images[5]->getObject()->getPixelHeightFromBottom());

        // Transpose the images into a sorted array so we can test sort order.
        $sortedImages = [];
        foreach ($images as $image) {
          $sortedImages[] = $image;
        }

        $this->assertEquals(1, $sortedImages[0]->getObject()->getPixelHeightFromBottom());
        $this->assertEquals(2, $sortedImages[1]->getObject()->getPixelHeightFromBottom());
        $this->assertEquals(3, $sortedImages[2]->getObject()->getPixelHeightFromBottom());
        $this->assertEquals(4, $sortedImages[3]->getObject()->getPixelHeightFromBottom());
        $this->assertEquals(5, $sortedImages[4]->getObject()->getPixelHeightFromBottom());
        $this->assertEquals(6, $sortedImages[5]->getObject()->getPixelHeightFromBottom());

        $object->sort('DESC');
        $images = $object->getIndividuals();

        // Transpose the images into a sorted array so we can test sort order.
        $sortedImages = [];
        foreach ($images as $image) {
          $sortedImages[] = $image;
        }

        $this->assertEquals(6, $sortedImages[0]->getObject()->getPixelHeightFromBottom());
        $this->assertEquals(5, $sortedImages[1]->getObject()->getPixelHeightFromBottom());
        $this->assertEquals(4, $sortedImages[2]->getObject()->getPixelHeightFromBottom());
        $this->assertEquals(3, $sortedImages[3]->getObject()->getPixelHeightFromBottom());
        $this->assertEquals(2, $sortedImages[4]->getObject()->getPixelHeightFromBottom());
        $this->assertEquals(1, $sortedImages[5]->getObject()->getPixelHeightFromBottom());
    }
}
