<?php

namespace Hashbangcode\Webolution\Generator;

/**
 * Class RandomTextGenerator.
 *
 * Allows the creation of random bits of text.
 *
 * @package Hashbangcode\Webolution\Generators
 */
trait RandomText
{

    /**
     * Generate an array of characters containing a-z, A-Z and a space.
     *
     * @return array
     *   An array of characters.
     */
    protected static function generateCharacterArray()
    {
        return array_merge(range('a', 'z'), range('A', 'Z'), [' ']);
    }

    /**
     * Generate a random letter.
     *
     * @return string
     *   A random letter.
     */
    public function getRandomLetter()
    {
        $charArray = static::generateCharacterArray();
        $randItem = array_rand($charArray);
        return $charArray[$randItem];
    }

    /**
     * Generate a random string of a specified length.
     *
     * @param int $textLength
     *   Length of string to generate.
     *
     * @return string
     *   The random string.
     */
    public static function generateRandomText($textLength = 7)
    {
        $text = "";
        $charArray = static::generateCharacterArray();
        for ($i = 0; $i < $textLength; $i++) {
            $randItem = array_rand($charArray);
            $text .= $charArray[$randItem];
        }
        return $text;
    }
}
