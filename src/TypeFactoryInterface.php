<?php

namespace Hashbangcode\Webolution;

use Hashbangcode\Webolution\Type\TypeInterface;

interface TypeFactoryInterface
{

    /**
     * Generate a random type object.
     *
     * @return TypeInterface
     *   The type object.
     */
    public static function generateRandom() : TypeInterface;
}
