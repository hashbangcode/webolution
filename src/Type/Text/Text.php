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


  /**
   * @return mixed
   */
  public function render() {
    return $this->getText();
  }
}