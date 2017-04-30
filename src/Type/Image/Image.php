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

    private $imageMatrix = [];

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
     * Render the image matrix to text.
     *
     * @return string
     *   The rendered image.
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

}