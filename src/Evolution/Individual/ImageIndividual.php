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
     *
     */
    public function mutateProperties()
    {
        $this->mutateImage($this->getMutationFactor());
        return $this;
    }

    /**
     * Mutate the image.
     *
     * @param int $amount
     *   The amount.
     *
     * @throws \Hashbangcode\Wevolution\Type\Image\Exception\InvalidPixelException
     */
    public function mutateImage($amount = 1)
    {
        $action = mt_rand(0, 100);

        if ($action <= 1) {
            $image = $this->getObject();

            $imageMatrix = $image->getImageMatrix();

            $x = array_rand($imageMatrix);
            $y = array_rand($imageMatrix[$x]);

            $value = $image->getPixel($x, $y);

            if ($value == 0) {
                $value = 1;
            } else {
                $value = 1;
            }

            $image->setPixel($x, $y, $value);
        }
    }

    /**
     * @return mixed
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
     * Render the image.
     *
     * @param string $renderType
     *   The image render type.
     *
     * @return string
     *   The rendered output.
     */
    public function render($renderType = 'cli')
    {
        switch ($renderType) {
            case 'image':
                $imageX = 100;
                $imageY = 100;

                $pixelSize = 10;

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
                $output = '<img width="100" height="100" src="data:image/jpg;base64,' . $image . '" /> ';

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