<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;

use Hashbangcode\Wevolution\Type\Image\Image;

/**
 * Class ImageIndividual
 * @package Hashbangcode\Wevolution\Evolution\Individual
 */
class ImageIndividual extends Individual
{
    /**
     * ImageIndividual constructor.
     *
     * @param int $x
     *   The x.
     * @param int $y
     *   The y.
     */
    public function __construct($x = 20, $y = 20)
    {
        $this->object = new Image($x, $y);
    }

    /**
     * @return \Hashbangcode\Wevolution\Evolution\Individual\ImageIndividual
     */
    public static function generateRandomImage()
    {
        $image = mt_rand(1, 10);
        return new ImageIndividual($image);
    }

    /**
     * {@inheritdoc}
     */
    public function mutate($mutationFactor = 0, $mutationAmount = 1)
    {
        $action = mt_rand(0, 100) + $mutationFactor;

        if ($action <= 50) {
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
            case 'html':
                $output = '<p>' . nl2br($this->object->render()) . '</p>';
                break;
            case 'cli':
                // Default fall through.
            default:
                $output = $this->object->render() . ' ';
        }
        return $output;
    }
}
