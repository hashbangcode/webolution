<?php

namespace Hashbangcode\Webolution\Type\Text;

use Hashbangcode\Webolution\Type\TypeInterface;
use Hashbangcode\Webolution\TypeFactoryInterface;
use Hashbangcode\Webolution\Type\Text\Text;
use Hashbangcode\Webolution\Generator\RandomText;

/**
 * Class TextFactory.
 *
 * @package Hashbangcode\Webolution\Type\Number
 */
class TextFactory implements TypeFactoryInterface
{
    use RandomText;

    /**
     * {@inheritdoc}
     */
    public static function generateRandom(): TypeInterface
    {
        $randomText = self::generateRandomText();
        $text = new Text($randomText);
        return $text;
    }

    /**
     * Generate a Text object with a given length.
     *
     * @param int $length
     *   The length text contained in the new Text object.
     * @return Text
     *   The new Text object.
     */
    public static function generateRandomWithLength($length = 10): Text
    {
        $randomText = self::generateRandomText($length);
        $text = new Text($randomText);
        return $text;
    }

    /**
     * Generate a Text object with a given string.
     *
     * @param int $string
     *   The string contained in the new Text object.
     * @return Text
     *   The new Text object.
     */
    public static function generateFromString($string): Text
    {
        $text = new Text($string);
        return $text;
    }
}
