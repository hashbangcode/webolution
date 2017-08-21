<?php

namespace Hashbangcode\Wevolution\Type\Image;

use Hashbangcode\Wevolution\Type\TypeInterface;

/**
 * Class Image
 *
 * @package Hashbangcode\Wevolution\Type\Image
 */
class Image implements TypeInterface
{

    /**
     * The image matrix.
     *
     * @var array
     */
    private $imageMatrix = [];

    /**
     * Image constructor.
     *
     * @param int $x
     *   The width.
     * @param int $y
     *   The height.
     */
    public function __construct($x = 20, $y = 20)
    {
        $this->createImageMatrix($x, $y);
    }

    /**
     * Get the image matrix.
     *
     * @return array
     *   The image matrix.
     */
    public function getImageMatrix()
    {
        return $this->imageMatrix;
    }

    /**
     * Set the image matrix.
     *
     * @param array $imageMatrix
     *   The new image matrix.
     */
    public function setImageMatrix(array $imageMatrix)
    {
        $this->imageMatrix = $imageMatrix;
    }

    /**
     * Set a pixel to a value.
     *
     * @param int $x
     *   The x coordinates.
     * @param $y
     *   The y coordinates.
     * @param $value
     *   The value to set the pixel to.
     *
     * @throws Exception\InvalidPixelException
     */
    public function setPixel($x, $y, $value)
    {
        if (!isset($this->imageMatrix[$x])) {
            throw new Exception\InvalidPixelException('Pixel not found at coordinates (' . $x . ', ' . $y . ')');
        }

        if (!isset($this->imageMatrix[$x][$y])) {
            throw new Exception\InvalidPixelException('Pixel not found at coordinates (' . $x . ', ' . $y . ')');
        }

        $this->imageMatrix[$x][$y] = $value;
    }

    /**
     * Get the value of a pixel.
     *
     * @param int $x
     *   The x coordinates.
     * @param $y
     *   The y coordinates.
     *
     * @return mixed
     *   The contents of the pixel.
     * @throws Exception\InvalidPixelException
     */
    public function getPixel($x, $y)
    {
        if (!isset($this->imageMatrix[$x])) {
            throw new Exception\InvalidPixelException('Pixel not found at coordinates (' . $x . ', ' . $y . ')');
        }

        if (!isset($this->imageMatrix[$x][$y])) {
            throw new Exception\InvalidPixelException('Pixel not found at coordinates (' . $x . ', ' . $y . ')');
        }

        return $this->imageMatrix[$x][$y];
    }

    /**
     * Create an image matrix.
     *
     * @param int $x
     *   The width of the matrix.
     * @param int $y
     *   The height of the matrix.
     *
     * @return $this
     *   The current object.
     */
    public function createImageMatrix($x = 20, $y = 20)
    {
        // Reset the image matrix.
        $this->imageMatrix = [];

        for ($i = 0; $i < $x; $i++) {
            $this->imageMatrix[$i] = [];
            for ($j = 0; $j < $y; $j++) {
                $this->imageMatrix[$i][$j] = 0;
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->imageMatrix as $xId => $x) {
            foreach ($x as $yId => $y) {
                $output .= $y;
            }
            $output .= PHP_EOL;
        }

        return trim($output);
    }

    /**
     * Render the image as a base64 encoded string.
     *
     * @return string
     *   The base64 version of the image.
     */
    public function renderBase64Image()
    {
        $imageMatrix = $this->getImageMatrix();

        // Calculate the size of the image.
        $imageX = (count($imageMatrix) + 100);
        $imageY = (count($imageMatrix[0]) + 100);

        // Calculate the size of a pixel.
        $pixelSize = $imageX / count($imageMatrix);

        // Set up image handle.
        $im = imagecreatetruecolor($imageX, $imageY);

        // Assign colours.
        $backgroundColor = imagecolorallocate($im, 255, 255, 255);
        $filledColor = imagecolorallocate($im, 132, 135, 28);

        // Generate image pixels.
        $xCoord = 0;

        foreach ($imageMatrix as $xId => $x) {
            $yCoord = 0;
            foreach ($x as $yId => $y) {
                // Find out the end of the rectangle.
                $xEnd = $xCoord + $pixelSize;
                $yEnd = $yCoord + $pixelSize;

                // Pick the right color.
                if ($y == 1) {
                    imagefilledrectangle($im, $yCoord, $xCoord, $yEnd, $xEnd, $filledColor);
                } else {
                    imagefilledrectangle($im, $yCoord, $xCoord, $yEnd, $xEnd, $backgroundColor);
                }
                $yCoord = $yCoord + $pixelSize;
            }
            $xCoord = $xCoord + $pixelSize;
        }

        // Render the image.
        ob_start();
        imagejpeg($im, null, 75);
        $rawImage = ob_get_contents();
        ob_end_clean();

        // Convert the image to
        return 'data:image/jpg;base64,' . base64_encode($rawImage);
    }

    /**
     * Find all of the pixels in the image that are blank, but adjacent to other pixels.
     *
     * @return array
     *   The coordinates of the adjacent pixels.
     */
    public function getAdjacentPixels()
    {
        $adjacentPixels = [];

        foreach ($this->imageMatrix as $xId => $x) {
            foreach ($x as $yId => $y) {
                if ($y == 1) {
                    /*
                     * This is a pixel so we look around to find adjacent pixels.
                     * (-1,-1)( 0,-1)(+1,-1)
                     * (-1, 0)       (+1, 0)
                     * (-1,+1)( 0,+1)(+1,+1)
                     */

                    // Upper left.
                    if (isset($this->imageMatrix[$xId - 1][$yId - 1]) && $this->imageMatrix[$xId - 1][$yId - 1] == 0) {
                        $adjacentPixels[($xId - 1)  . ($yId - 1)] = ['x' => $xId - 1, 'y' => $yId - 1];
                    }
                    // Upper middle.
                    if (isset($this->imageMatrix[$xId][$yId - 1]) && $this->imageMatrix[$xId][$yId - 1] == 0) {
                        $adjacentPixels[$xId . ($yId - 1)] = ['x' => $xId, 'y' => $yId - 1];
                    }
                    // Upper right.
                    if (isset($this->imageMatrix[$xId + 1][$yId - 1]) && $this->imageMatrix[$xId + 1][$yId - 1] == 0) {
                        $adjacentPixels[($xId + 1) . ($yId - 1)] = ['x' => $xId + 1, 'y' => $yId - 1];
                    }
                    // Middle left.
                    if (isset($this->imageMatrix[$xId - 1][$yId]) && $this->imageMatrix[$xId - 1][$yId] == 0) {
                        $adjacentPixels[($xId - 1) . $yId] = ['x' => $xId - 1, 'y' => $yId];
                    }
                    // Middle Right.
                    if (isset($this->imageMatrix[$xId + 1][$yId]) && $this->imageMatrix[$xId + 1][$yId] == 0) {
                        $adjacentPixels[($xId + 1) . $yId] = ['x' => $xId + 1, 'y' => $yId];
                    }
                    // Lower left.
                    if (isset($this->imageMatrix[$xId - 1][$yId + 1]) && $this->imageMatrix[$xId - 1][$yId + 1] == 0) {
                        $adjacentPixels[($xId - 1) . ($yId + 1)] = ['x' => $xId - 1, 'y' => $yId + 1];
                    }
                    // Lower middle.
                    if (isset($this->imageMatrix[$xId][$yId + 1]) && $this->imageMatrix[$xId][$yId + 1] == 0) {
                        $adjacentPixels[$xId . ($yId + 1)] = ['x' => $xId, 'y' => $yId + 1];
                    }
                    // Lower right.
                    if (isset($this->imageMatrix[$xId + 1][$yId + 1]) && $this->imageMatrix[$xId + 1][$yId + 1] == 0) {
                        $adjacentPixels[($xId + 1) . ($yId + 1)] = ['x' => $xId + 1, 'y' => $yId + 1];
                    }
                }
            }
        }

        return $adjacentPixels;
    }

    /**
     * Get the number of active pixels.
     *
     * @return int
     *   The number of activ pixels.
     */
    public function getActivePixels()
    {
        $numberOnes = 0;

        $imageMatrix = $this->getImageMatrix();

        foreach ($imageMatrix as $xId => $x) {
            foreach ($x as $yId => $y) {
                if ($y == 1) {
                    $numberOnes++;
                }
            }
        }

        return $numberOnes;
    }

    /**
     * Get the height of the active pixels in the image.
     *
     * @todo : change the name of this method. it's confusing.
     *
     * @return int
     *   The height.
     */
    public function getHeight()
    {
        $imageMatrix = $this->getImageMatrix();
        $height = 0;

        for ($x = count($imageMatrix) - 1; $x > 0; $x--) {
            for ($y = count($imageMatrix[$x]) - 1; $y > 0; $y--) {
                if ($imageMatrix[$x][$y] == 1) {
                    $height++;
                    break;
                }
            }
        }

        return $height;
    }
}
