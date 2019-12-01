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
        $image = new Image();
        return $image;
    }
}
