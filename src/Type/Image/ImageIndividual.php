<?php

namespace Hashbangcode\Webolution\Type\Image;

use Hashbangcode\Webolution\Individual;

/**
 * Class ImageIndividual
 * @package Hashbangcode\Webolution\Individual
 */
class ImageIndividual extends Individual
{

    /**
     * Generate an image with a given size.
     *
     * @param int $x
     *   The width of the image.
     * @param int $y
     *   The height of the image.
     *
     * @return \Hashbangcode\Webolution\Type\Image\ImageIndividual
     *   An ImageIndividual.
     */
    public static function generateFromImageSize($x = 20, $y = 20)
    {
        return new self(new Image($x, $y));
    }

    /**
     * Generate a random image with a ranom size.
     *
     * @return \Hashbangcode\Webolution\Type\Image\ImageIndividual
     *   An ImageIndividual.
     */
    public static function generateRandomImage()
    {
        return new self(ImageFactory::generateRandom());
    }

    /**
     * Generate the image from a matrix.
     *
     * @param array $matrix
     *   The matrix to generate the image from.
     *
     * @return \Hashbangcode\Webolution\Type\Image\ImageIndividual
     *   An ImageIndividual.
     */
    public static function generateFromMatrix($matrix)
    {
        $imageObject = new Image();
        $imageObject->setImageMatrix($matrix);
        return new self($imageObject);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        // The name of the ImageIndividual is the number of active pixels.
        return $this->getObject()->getActivePixels();
    }

    /**
     * {@inheritdoc}
     */
    public function getSpecies(): string
    {
        // The species of the ImageIndividual is the height of the image.
        return (string) $this->getObject()->getPixelHeightFromBottom();
    }

    /**
     * {@inheritdoc}
     */
    public function mutate($mutationFactor = 0, $mutationAmount = 1)
    {
        $action = mt_rand(0, 100) + $mutationFactor;

        if ($action <= 75) {
            $image = $this->getObject();

            $imageMatrix = $image->getImageMatrix();

            $pixels = $image->getAdjacentPixels();

            if (count($pixels) > 0) {
                // Get a pixel from the adjacent pixels.
                $randomAdjacentPixel = array_rand($pixels);
                $randomAdjacentPixel = $pixels[$randomAdjacentPixel];

                $x = $randomAdjacentPixel['x'];
                $y = $randomAdjacentPixel['y'];
            } else {
                // Select a random pixel.
                $x = array_rand($imageMatrix);
                $y = array_rand($imageMatrix[$x]);
            }

            $value = $image->getPixel($x, $y);

            if ($value == 0) {
                $value = 1;
            } else {
                $value = 0;
            }

            $image->setPixel($x, $y, $value);
        }
    }

    /**
     * {@inheritdoc}
     *
     * For Image types we return the number of "on" pixels in the image.
     */
    public function getFitness($type = ''): float
    {
        switch ($type) {
            case 'height':
                return $this->getObject()->getPixelHeightFromBottom();
            default:
                return $this->getObject()->getActivePixels();
        }
    }
}
