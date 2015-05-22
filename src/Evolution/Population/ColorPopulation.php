<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;
use Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual;

class ColorPopulation extends Population
{

  public function sort($sortBy = 'hue', $direction = 'ASC') {
    $colors = array();

    foreach ($this->individuals as $individual) {
      $color = $individual->getObject();
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

  public function addIndividual(Individual $individual = NULL) {
    if (is_null($individual)) {
      $individual = ColorIndividual::generateRandomColor();
    }

    $this->individuals[] = $individual;
    $this->length++;
  }

  public function toString() {
    foreach ($this->colors as $color) {
      print $color->getHex() . PHP_EOL;
    }
  }
}