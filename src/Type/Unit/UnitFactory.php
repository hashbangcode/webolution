<?php

namespace Hashbangcode\Webolution\Type\Unit;

use Hashbangcode\Webolution\Type\TypeInterface;
use Hashbangcode\Webolution\TypeFactoryInterface;
use Hashbangcode\Webolution\Type\Unit\Unit;

/**
 * Class UnitFactory.
 *
 * @package Hashbangcode\Webolution\Type\Number
 */
class UnitFactory implements TypeFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public static function generateRandom(): TypeInterface
    {
        $number = mt_rand(1, 500);
        $units = ['px', 'em', '%', 'auto'];
        $unit = $units[array_rand($units)];
        return new Unit($number, $unit);
    }
}
