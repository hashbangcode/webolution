<?php

namespace Hashbangcode\Webolution\Type\Style;

use Hashbangcode\Webolution\Type\TypeInterface;
use Hashbangcode\Webolution\TypeFactoryInterface;
use Hashbangcode\Webolution\Type\Style\Style;

/**
 * Class StyleFactory.
 *
 * @package Hashbangcode\Webolution\Type\Number
 */
class StyleFactory implements TypeFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public static function generateRandom(): TypeInterface
    {
        $style = new Style();
        return $style;
    }
}
