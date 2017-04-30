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
     * @param $renderType
     * @return mixed
     */
    public function render($renderType = 'cli')
    {
        switch ($renderType) {
            case 'html':
                $output = '<p>' . nl2br($this->object->render()) . '</p>';
                break;
            case 'cli':
            default:
                $output = $this->object->render() . ' ';
        }
        return $output;
    }
}