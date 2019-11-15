<?php

namespace Hashbangcode\Webolution\Type\Image\Decorator;

use Hashbangcode\Webolution\IndividualDecorator;

/**
 * Class ImageIndividualDecoratorHtml.
 *
 * @package Hashbangcode\Webolution\Evolution\Individual\Decorators
 */
class ImageIndividualDecoratorHtml extends IndividualDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $imageMatrix = $this->getIndividual()->getObject()->getImageMatrix();

        // Calculate the size of the image.
        $imageX = (count($imageMatrix) + 100);
        $imageY = (count($imageMatrix[0]) + 100);

        // Render the image into base64.
        $image = $this->renderBase64Image($imageMatrix);

        // Render the image into an image tag.
        return '<img width="' . $imageX . '" height="' . $imageY . '" src="' . $image . '" /> ';
    }

    /**
     * Render the image as a base64 encoded string.
     *
     * @param array $imageMatrix
     *   The image matrix to render.
     *
     * @return string
     *   The base64 version of the image.
     */
    public function renderBase64Image($imageMatrix)
    {
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
        $yCoord = 0;

        foreach ($imageMatrix as $yId => $y) {
            $xCoord = 0;
            foreach ($y as $xId => $x) {
                // Find out the end of the rectangle.
                $yEnd = $yCoord + $pixelSize;
                $xEnd = $xCoord + $pixelSize;

                // Pick the right color.
                if ($x == 1) {
                    imagefilledrectangle($im, $xCoord, $yCoord, $xEnd, $yEnd, $filledColor);
                } else {
                    imagefilledrectangle($im, $xCoord, $yCoord, $xEnd, $yEnd, $backgroundColor);
                }
                $xCoord = $xCoord + $pixelSize;
            }
            $yCoord = $yCoord + $pixelSize;
        }

        // Render the image.
        ob_start();
        imagejpeg($im, null, 75);
        $rawImage = ob_get_contents();
        ob_end_clean();

        // Convert the image to
        return 'data:image/jpg;base64,' . base64_encode($rawImage);
    }
}
