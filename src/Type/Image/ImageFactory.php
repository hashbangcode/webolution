<?php

namespace Hashbangcode\Webolution\Type\Image;

use Hashbangcode\Webolution\Type\TypeInterface;
use Hashbangcode\Webolution\TypeFactoryInterface;
use Hashbangcode\Webolution\Type\Image\Image;

/**
 * Class NumberFactory.
 *
 * @package Hashbangcode\Webolution\Type\Number
 */
class ImageFactory implements TypeFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public static function generateRandom(): TypeInterface
    {
        $image = new Image(mt_rand(1, 20), mt_rand(1, 20));
        return $image;
    }
}
