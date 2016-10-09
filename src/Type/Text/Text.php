<?php

namespace Hashbangcode\Wevolution\Type\Text;

/**
 * Class Text
 * @package Hashbangcode\Wevolution\Type\Text
 */
class Text
{
  protected $text;

  /**
   * @return mixed
   */
  public function getText()
  {
    return $this->text;
  }

  /**
   * @param mixed $text
   */
  public function setText($text)
  {
    $this->text = $text;
  }

  /**
   * Text constructor.
   * @param $text
   */
  public function __construct($text) {
    $this->setText($text);
  }

  public function mutateText() {

    $text = $this->getText();

    $text_length = strlen($text);

    $random = mt_rand(0, 1000) / 1000;
    if ($random < 0.1 && 1==2) {

      // @todo remove text as well..
      $this->setText($text . $this->getRandomLetter());

    } else {
      // Ger a random letter from the current string.
      $letter_position = mt_rand(0, strlen($text) - 1);

      $text = str_split($text);
      $letter = $text[$letter_position];

      if ($letter == 'z') {
        $newletter = 'A';
      }
      elseif ($letter == 'Z') {
        $newletter = ' ';
      }
      elseif ($letter == ' ') {
        $newletter = 'a';
      }
      else {
        $newletter = chr(ord($letter) + 1);
      }

      // Swap it for a random letter.
      $text[$letter_position] = $newletter;

      $text = implode('', $text);

      if (strlen($text) > 7) {
        $something = 1 + 1;
      }

      $this->setText($text);
    }
  }

  public function getRandomLetter() {
    $charArray = array_merge(range('a', 'z'), range('A', 'Z'));
    $charArray[] = ' ';
    $randItem = array_rand($charArray);
    return $charArray[$randItem];
  }

  /**
   * @return mixed
   */
  public function render() {
    return $this->getText();
  }
}