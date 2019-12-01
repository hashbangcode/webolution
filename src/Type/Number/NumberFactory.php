<?php

namespace Hashbangcode\Webolution\Type\Number;

use Hashbangcode\Webolution\Type\TypeInterface;
use Hashbangcode\Webolution\TypeFactoryInterface;
use Hashbangcode\Webolution\Type\Number\Number;

/**
 * Class NumberFactory.
 *
 * @package Hashbangcode\Webolution\Type\Number
 */
class NumberFactory implements TypeFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public static function generateRandom(): TypeInterface
    {
        return new Number(mt_rand(1, 10));
    }
}
