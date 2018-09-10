<?php

namespace Hashbangcode\Webolution\Evolution\Individual;

use Hashbangcode\Webolution\Type\Image\Image;

/**
 * Class ImageIndividual
 * @package Hashbangcode\Webolution\Evolution\Individual
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
     * @return \Hashbangcode\Webolution\Evolution\Individual\ImageIndividual
     *   An ImageIndividual.
     */
    public static function generateFromImageSize($x = 20, $y = 20)
    {
        return new self(new Image($x, $y));
    }

    /**
     * Generate a random image with a ranom size.
     *
     * @return \Hashbangcode\Webolution\Evolution\Individual\ImageIndividual
     *   An ImageIndividual.
     */
    public static function generateRandomImage()
    {
        return new self(new Image(mt_rand(1, 20), mt_rand(1, 20)));
    }

    /**
     * Generate the image from a matrix.
     *
     * @param array $matrix
     *   The matrix to generate the image from.
     *
     * @return \Hashbangcode\Webolution\Evolution\Individual\ImageIndividual
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
    public function getFitness($type = '')
    {
        switch ($type) {
            case 'height':
                return $this->getObject()->getHeight();
            default:
                return $this->getObject()->getActivePixels();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function render($renderType = 'cli')
    {
        switch ($renderType) {
            case 'image':
                $imageMatrix = $this->getObject()->getImageMatrix();

                // Calculate the size of the image.
                $imageX = (count($imageMatrix) + 100);
                $imageY = (count($imageMatrix[0]) + 100);

                // Render the image.
                $image = $this->getObject()->renderBase64Image();

                return '<img width="' . $imageX . '" height="' . $imageY . '" src="' . $image . '" /> ';
            case self::RENDER_HTML:
                $output = '<p>' . nl2br($this->object->render()) . '</p>';
                break;
            case self::RENDER_CLI:
                // Default fall through.
            default:
                $output = $this->object->render() . ' ';
        }
        return $output;
    }
}
