<?php

namespace Hashbangcode\Webolution\Test\Type\Image;

use Hashbangcode\Webolution\Type\Image\Decorator\ImageIndividualDecoratorCli;
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

    public function testGenerateImageFromMatrix()
    {
        $imageMatrix = array_fill_keys(range(0, 9), 0);
        foreach ($imageMatrix as $id => $imagePart) {
            $imageMatrix[$id] = array_fill_keys(range(0, 9), 0);
        }

        $imageMatrix[9][5] = 1;

        $image = ImageIndividual::generateFromMatrix($imageMatrix);

        $this->assertEquals('1', $image->getName());
        $this->assertEquals('1', $image->getSpecies());

        $this->assertEquals(1, $image->getFitness('height'));
    }

    /**
     * @dataProvider imageFitnessDataProvider
     */
    public function testFitnessOfImageIndividual($matrix, $fitness)
    {
        $object = ImageIndividual::generateFromMatrix($matrix);
        $this->assertEquals($fitness, $object->getFitness('height'));
    }

    /**
     * Data provider for testFitnessOfImageIndividual.
     *
     * @return array
     */
    public function imageFitnessDataProvider()
    {
        $data = [];

        $masterImageMatrix = array_fill_keys(range(0, 9), 0);
        foreach ($masterImageMatrix as $id => $imagePart) {
            $masterImageMatrix[$id] = array_fill_keys(range(0, 9), 0);
        }

        $data[] = [$masterImageMatrix, 0];

        $imageMatrix = $masterImageMatrix;
        $imageMatrix[9][9] = 1;
        $data[] = [$imageMatrix, 1];

        $imageMatrix = $masterImageMatrix;
        $imageMatrix[9][9] = 1;
        $imageMatrix[8][9] = 1;
        $data[] = [$imageMatrix, 2];

        $imageMatrix = $masterImageMatrix;
        $imageMatrix[9][9] = 1;
        $imageMatrix[8][9] = 1;
        $imageMatrix[7][9] = 1;
        $data[] = [$imageMatrix, 3];

        $imageMatrix = $masterImageMatrix;
        $imageMatrix[9][9] = 1;
        $imageMatrix[8][9] = 1;
        $imageMatrix[7][9] = 1;
        $imageMatrix[6][9] = 1;
        $data[] = [$imageMatrix, 4];

        $imageMatrix = $masterImageMatrix;
        $imageMatrix[9][9] = 1;
        $imageMatrix[8][9] = 1;
        $imageMatrix[7][9] = 1;
        $imageMatrix[6][9] = 1;
        $imageMatrix[5][9] = 1;
        $data[] = [$imageMatrix, 5];

        $imageMatrix = $masterImageMatrix;
        $imageMatrix[9][9] = 1;
        $imageMatrix[8][9] = 1;
        $imageMatrix[7][9] = 1;
        $imageMatrix[6][9] = 1;
        $imageMatrix[5][9] = 1;
        $imageMatrix[4][9] = 1;
        $data[] = [$imageMatrix, 6];

        $imageMatrix = $masterImageMatrix;
        $imageMatrix[9][9] = 1;
        $imageMatrix[8][9] = 1;
        $imageMatrix[7][9] = 1;
        $imageMatrix[6][9] = 1;
        $imageMatrix[5][9] = 1;
        $imageMatrix[4][9] = 1;
        $imageMatrix[3][9] = 1;
        $data[] = [$imageMatrix, 7];

        $imageMatrix = $masterImageMatrix;
        $imageMatrix[9][9] = 1;
        $imageMatrix[8][9] = 1;
        $imageMatrix[7][9] = 1;
        $imageMatrix[6][9] = 1;
        $imageMatrix[5][9] = 1;
        $imageMatrix[4][9] = 1;
        $imageMatrix[3][9] = 1;
        $imageMatrix[2][9] = 1;
        $data[] = [$imageMatrix, 8];

        $imageMatrix = $masterImageMatrix;
        $imageMatrix[9][9] = 1;
        $imageMatrix[8][9] = 1;
        $imageMatrix[7][9] = 1;
        $imageMatrix[6][9] = 1;
        $imageMatrix[5][9] = 1;
        $imageMatrix[4][9] = 1;
        $imageMatrix[3][9] = 1;
        $imageMatrix[2][9] = 1;
        $imageMatrix[1][9] = 1;
        $data[] = [$imageMatrix, 9];

        $imageMatrix = $masterImageMatrix;
        $imageMatrix[9][9] = 1;
        $imageMatrix[8][9] = 1;
        $imageMatrix[7][9] = 1;
        $imageMatrix[6][9] = 1;
        $imageMatrix[5][9] = 1;
        $imageMatrix[4][9] = 1;
        $imageMatrix[3][9] = 1;
        $imageMatrix[2][9] = 1;
        $imageMatrix[1][9] = 1;
        $imageMatrix[0][9] = 1;
        $data[] = [$imageMatrix, 10];

        $imageMatrix = $masterImageMatrix;
        $imageMatrix[9][9] = 1;
        $imageMatrix[8][9] = 1;
        $imageMatrix[7][9] = 1;
        $imageMatrix[6][9] = 1;
        $imageMatrix[5][1] = 1;
        $imageMatrix[5][2] = 1;
        $imageMatrix[5][3] = 1;
        $imageMatrix[5][4] = 1;
        $imageMatrix[5][5] = 1;
        $imageMatrix[5][6] = 1;
        $data[] = [$imageMatrix, 5];

        $imageMatrix = $masterImageMatrix;
        $imageMatrix[9][9] = 1;
        $imageMatrix[8][8] = 1;
        $imageMatrix[7][7] = 1;
        $imageMatrix[6][6] = 1;
        $imageMatrix[5][5] = 1;
        $imageMatrix[4][4] = 1;
        $imageMatrix[3][3] = 1;
        $imageMatrix[2][2] = 1;
        $imageMatrix[1][1] = 1;
        $imageMatrix[0][0] = 1;
        $data[] = [$imageMatrix, 10];

        $imageMatrix = $masterImageMatrix;
        $imageMatrix[9][0] = 1;
        $imageMatrix[9][1] = 1;
        $imageMatrix[9][2] = 1;
        $imageMatrix[9][3] = 1;
        $imageMatrix[9][4] = 1;
        $imageMatrix[9][5] = 1;
        $imageMatrix[9][6] = 1;
        $imageMatrix[9][7] = 1;
        $imageMatrix[9][8] = 1;
        $imageMatrix[9][9] = 1;
        $data[] = [$imageMatrix, 1];

        $imageMatrix = $masterImageMatrix;
        $imageMatrix[9][0] = 1;
        $imageMatrix[9][1] = 1;
        $imageMatrix[9][2] = 1;
        $imageMatrix[9][3] = 1;
        $imageMatrix[9][4] = 1;
        $imageMatrix[9][5] = 1;
        $imageMatrix[8][5] = 1;
        $imageMatrix[9][6] = 1;
        $imageMatrix[9][7] = 1;
        $imageMatrix[9][8] = 1;
        $imageMatrix[9][9] = 1;
        $data[] = [$imageMatrix, 2];

        $imageMatrix = $masterImageMatrix;
        $imageMatrix[5][5] = 1;
        $data[] = [$imageMatrix, 1];

        return $data;
    }
}
