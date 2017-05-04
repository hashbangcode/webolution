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
    public function getFitness()
    {
        $imageMatrix = $this->getObject()->getImageMatrix();

        $numberOnes = 0;

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
     * {@inheritdoc}
     */
    public function render($renderType = 'cli')
    {
        switch ($renderType) {
            case 'image':
                $imageMatrix = $this->object->getImageMatrix();

                $imageX = (count($imageMatrix) + 100);
                $imageY = (count($imageMatrix[0]) + 100);

                $pixelSize = $imageX / count($imageMatrix);

                $im = imagecreatetruecolor($imageX, $imageY);

                $backgroundColor = imagecolorallocate($im, 255, 255, 255);
                $filledColor = imagecolorallocate($im, 132, 135, 28);

                $xCoord = 0;

                $imageMatrix = $this->object->getImageMatrix();

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

                ob_start();
                imagejpeg($im, null, 75);
                $rawImage = ob_get_contents();
                ob_end_clean();

                $image = base64_encode($rawImage);
                $output = '<img width="' . $imageX . '" height="' . $imageY . '" src="data:image/jpg;base64,' . $image . '" /> ';

                break;
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