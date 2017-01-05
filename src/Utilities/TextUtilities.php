<?php

namespace Hashbangcode\Wevolution\Utilities;

trait TextUtilities
{

  /**
   * @return mixed
   */
  public function getRandomLetter()
  {
    $charArray = array_merge(range('a', 'z'), range('A', 'Z'));
    $charArray[] = ' ';
    $randItem = array_rand($charArray);
    return $charArray[$randItem];
  }

  /**
   * @param int $textLength
   * @return string
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