<?php

namespace Hashbangcode\Webolution\Utilities;

/**
 * Class TextUtilities. Stores some text utilities that can be used elsewhere in the application.
 *
 * @package Hashbangcode\Webolution\Utilities
 */
trait TextUtilities
{

    /**
     * Generate a random letter. This will be in the range a - z and A - Z.
     *
     * @return mixed
     *   A random letter.
     */
    public function getRandomLetter()
    {
        $charArray = array_merge(range('a', 'z'), range('A', 'Z'));
        $charArray[] = ' ';
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
        $charArray = array_merge(range('a', 'z'), range('A', 'Z'), [' ']);
        for ($i = 0; $i < $textLength; $i++) {
            $randItem = array_rand($charArray);
            $text .= $charArray[$randItem];
        }
        return $text;
    }
}