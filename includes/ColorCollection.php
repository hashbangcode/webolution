<?php

/**
 * Class ColorCollection
 */
class ColorCollection
{

  private $length = 0;

  private $colors = array();

  public function ColorCollection() {

  }

  public function getLength() {
    return $this->length;
  }

  public function add(Color $color) {
    $this->colors[] = $color;
    $this->length++;
  }

  public function sort($sortBy = 'hue', $direction = 'ASC') {
    $colors = array();

    foreach ($this->colors as $color) {
      switch ($sortBy) {
        case 'hue':
          $index = $color->getHue() * 100;
          break;
        case 'intensity':
          $index = $color->getIntensity() * 100;
          break;
        case 'hsi_saturation':
          $index = $color->getHsiSaturation() * 100;
          break;
      }

      if (isset($colors[$index])) {
        while (isset($colors[$index])) {
          $index++;
        }
        $colors[$index] = $color;
      } else {
        $colors[$index] = $color;
      }
    }

    if ($direction === 'ASC') {
      ksort($colors);
    } else {
      krsort($colors);
    }

    $this->colors = $colors;
  }

  public function getColors() {
    return $this->colors;
  }

  public function toString() {
    foreach ($this->colors as $color) {
      print $color->getHex() . PHP_EOL;
    }
  }
}