<?php

namespace Hashbangcode\Webolution\Type\Image\Decorator;

use Hashbangcode\Webolution\IndividualDecorator;

/**
 * Class ImageIndividualDecoratorCli.
 *
 * @package Hashbangcode\Webolution\Type\Image\Decorator
 */
class ImageIndividualDecoratorCli extends IndividualDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        $imageMatrix = $this->getIndividual()->getObject()->getImageMatrix();

        foreach ($imageMatrix as $xId => $x) {
            foreach ($x as $yId => $y) {
                $output .= $y;
            }
            $output .= PHP_EOL;
        }

        return trim($output);
    }
}
