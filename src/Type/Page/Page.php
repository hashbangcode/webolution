<?php

namespace Hashbangcode\Wevolution\Type\Page;

use Hashbangcode\Wevolution\Type\Style\Style;
use Hashbangcode\Wevolution\Type\Element\Element;

/**
 * Class Page
 * @package Hashbangcode\Wevolution\Type\Page
 */
class Page
{
  /**
   * @var Hashbangcode\Wevolution\Type\Style
   */
  protected $style;

  /**
   * @var Hashbangcode\Wevolution\Type\Element
   */
  protected $body;

  /**
   * @return Hashbangcode\Wevolution\Type\Style
   */
  public function getStyle() {
    return $this->style;
  }

  /**
   * @param Hashbangcode\Wevolution\Type\Style $style
   */
  public function setStyle($style) {
    $this->style = $style;
  }

  /**
   * @return Hashbangcode\Wevolution\Type\Element
   */
  public function getBody() {
    return $this->body;
  }

  /**
   * @param Hashbangcode\Wevolution\Type\Element $body
   */
  public function setBody($body) {
    $this->body = $body;
  }

  /**
   * @return mixed
   */
  public function render()
  {
    $style = '';

    if ($this->getStyle() instanceof Style) {
      $style = PHP_EOL . '<style>' . $this->getStyle()->render() . '</style>';
    }

    $body = '';

    if ($this->getBody() instanceof Element) {
      $body = PHP_EOL . $this->getBody()->render();
    }

    return '<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>' . $style . '
    </head>
    <body>' . $body . '
    </body>
</html>';
  }
}