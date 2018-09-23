<?php

namespace Hashbangcode\Webolution\Test\Type\Image;

use Hashbangcode\Webolution\Type\Image\Image;

/**
 * Test class for Image
 */
class ImageTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateSizedImage()
    {
        $object = new Image(30, 30);
        $matrix = $object->getImageMatrix();

        $this->assertEquals(30, count($matrix[0]), 'Assert that x is correct.');
        $this->assertEquals(30, count($matrix[29]), 'Assert that end x is correct.');
        $this->assertTrue(isset($matrix[29][29]), 'Assert that end y is correct.');
        $this->assertEquals(0, $matrix[0][0], 'Assert that y is correct.');
    }

    public function testCreateImageMatrix()
    {
        $object = new Image();
        $object->createImageMatrix(5, 5);

        $matrix = $object->getImageMatrix();

        $this->assertEquals(5, count($matrix[0]), 'Assert that x is correct.');
        $this->assertEquals(5, count($matrix[4]), 'Assert that end x is correct.');
        $this->assertTrue(isset($matrix[4][4]), 'Assert that end y is correct.');
        $this->assertEquals(0, $matrix[0][0], 'Assert that y is correct.');
    }

    public function testReplaceImageMatrix()
    {
        $object = new Image();

        $imageMatrix = [
            0 => [0 => 1, 1 => 1, 2 => 1],
            1 => [0 => 0, 1 => 0, 2 => 0],
            2 => [0 => 0, 1 => 0, 2 => 0],
        ];

        $object->setImageMatrix($imageMatrix);

        $matrix = $object->getImageMatrix();

        $this->assertEquals($matrix, $imageMatrix, 'Assert that the matrix set is expected.');

        $this->assertEquals(3, count($matrix[0]), 'Assert that x is correct.');
        $this->assertEquals(3, count($matrix[2]), 'Assert that end x is correct.');
        $this->assertTrue(isset($matrix[2][2]), 'Assert that end y is correct.');
        $this->assertEquals(1, $matrix[0][2], 'Assert that y is correct.');
    }

    public function testSetPixel()
    {
        $object = new Image();
        $object->createImageMatrix(5, 5);
        $object->setPixel(2, 2, 1);
        $this->assertEquals(1, $object->getPixel(2, 2), 'Assert that the pixel value is the same as set.');
    }

    public function testSetInvalidXPixel()
    {
        $object = new Image();
        $object->createImageMatrix(5, 5);
        $message = 'Pixel not found at coordinates (100, 100)';
        $this->setExpectedException('Hashbangcode\Webolution\Type\Image\Exception\InvalidPixelException', $message);
        $object->setPixel(100, 100, 1);
    }

    public function testGetInvalidXPixel()
    {
        $object = new Image();
        $object->createImageMatrix(5, 5);
        $message = 'Pixel not found at coordinates (100, 100)';
        $this->setExpectedException('Hashbangcode\Webolution\Type\Image\Exception\InvalidPixelException', $message);
        $object->getPixel(100, 100);
    }

    public function testSetInvalidXyPixel()
    {
        $object = new Image();
        $object->createImageMatrix(5, 5);
        $message = 'Pixel not found at coordinates (2, 100)';
        $this->setExpectedException('Hashbangcode\Webolution\Type\Image\Exception\InvalidPixelException', $message);
        $object->setPixel(2, 100, 1);
    }

    public function testGetInvalidXyPixel()
    {
        $object = new Image();
        $object->createImageMatrix(5, 5);
        $message = 'Pixel not found at coordinates (2, 100)';
        $this->setExpectedException('Hashbangcode\Webolution\Type\Image\Exception\InvalidPixelException', $message);
        $object->getPixel(2, 100);
    }

    public function testAdjacentPixelsWith1Pixel()
    {
        $object = new Image(5, 5);

        /*
         * 01234
         * 00000 0 (0,0) (0,1) (0,2)
         * 01000 1 (1,0)       (1,2)
         * 00000 2 (2,0) (2,1) (2,2)
         * 00000 3
         * 00000 4
         */

        $object->setPixel(1, 1, 1);

        $adjacentPixels = $object->getAdjacentPixels();

        $this->assertEquals(8, count($adjacentPixels));
    }

    public function testAdjacentPixelsWithEdgePixel()
    {
        $object = new Image(5, 5);

        /*
         * 01234
         * 10000 0 (0,1)
         * 00000 1 (1,0) (1,1)
         * 00000 2
         * 00000 3
         * 00000 4
         */

        $object->setPixel(0, 0, 1);

        $adjacentPixels = $object->getAdjacentPixels();

        $this->assertEquals(3, count($adjacentPixels));
    }

    public function testAdjacentPixelsWith2Pixels()
    {
        $object = new Image(5, 5);

        /*
         * 01234
         * 00000 0 (0,0) (0,1) (0,2) (0,3)
         * 01100 1 (1,0)             (1,3)
         * 00000 2 (2,0) (2,1) (2,2) (2,3)
         * 00000 3
         * 00000 4
         */

        $object->setPixel(1, 1, 1);
        $object->setPixel(1, 2, 1);

        $adjacentPixels = $object->getAdjacentPixels();

        $this->assertEquals(10, count($adjacentPixels));
    }

    public function testAdjacentPixelsWithFourCorners()
    {
        $object = new Image(5, 5);

        /*
         * 01234
         * 10001 0       (0,1)   (0,3)
         * 00000 1 (1,0) (1,1)   (1,3) (1,4)
         * 00000 2
         * 00000 3 (3,0) (3,1)   (3,3) (3,4)
         * 10001 4       (4,1)   (4,3)
         */

        $object->setPixel(0, 0, 1);
        $object->setPixel(4, 0, 1);
        $object->setPixel(0, 4, 1);
        $object->setPixel(4, 4, 1);

        $adjacentPixels = $object->getAdjacentPixels();

        $this->assertEquals(12, count($adjacentPixels));
    }

    public function testGetActivePixels()
    {
        $image = new Image(5, 5);
        $image->setPixel(3, 2, 1);
        $image->setPixel(4, 2, 1);

        $this->assertEquals(2, $image->getActivePixels());
    }

    public function testGetHeightSimple()
    {
        $image = new Image(5, 5);
        $image->setPixel(3, 2, 1);
        $image->setPixel(4, 2, 1);

        $this->assertEquals(2, $image->getHeight());
    }

    public function testGetHeightComplex()
    {
        $image = new Image(10, 10);

        // Set height pixels.
        $image->setPixel(9, 5, 1);
        $image->setPixel(8, 5, 1);
        $image->setPixel(7, 5, 1);
        $image->setPixel(6, 5, 1);
        $image->setPixel(5, 5, 1);
        $image->setPixel(4, 5, 1);

        // Set noise pixels.
        $image->setPixel(9, 0, 1);
        $image->setPixel(9, 1, 1);
        $image->setPixel(9, 2, 1);
        $image->setPixel(9, 3, 1);
        $image->setPixel(9, 4, 1);
        $image->setPixel(9, 6, 1);
        $image->setPixel(9, 7, 1);
        $image->setPixel(9, 8, 1);
        $image->setPixel(9, 9, 1);
        $image->setPixel(8, 2, 1);
        $image->setPixel(7, 3, 1);
        $image->setPixel(7, 9, 1);
        $image->setPixel(5, 0, 1);

        $this->assertEquals(6, $image->getHeight());
    }
}
