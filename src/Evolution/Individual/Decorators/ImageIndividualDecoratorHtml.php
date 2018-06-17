<?php

namespace Hashbangcode\Wevolution\Evolution\Individual\Decorators;

/**
 * Class ImageIndividualDecoratorHtml.
 *
 * @package Hashbangcode\Wevolution\Evolution\Individual\Decorators
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
        $image = $this->getIndividual()->getObject()->renderBase64Image();

        // Render the image into an image tag.
        return '<img width="' . $imageX . '" height="' . $imageY . '" src="' . $image . '" /> ';
    }
}
