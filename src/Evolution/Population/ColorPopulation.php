<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;
use Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual;

/**
 * Class ColorPopulation
 * @package Hashbangcode\Wevolution\Evolution\Population
 */
class ColorPopulation extends Population
{

  /**
   * @param string $sortBy
   * @param string $direction
   */
  public function sort($sortBy = 'hue', $direction = 'ASC') {
    $colors = array();

    // @todo : this technically works, but is shit.
    foreach ($this->individuals as $index => $individual) {
      switch ($sortBy) {
        case 'hue':
          $new_index = $individual->getObject()->getHue() * 100;
          break;
        case 'intensity':
          $new_index = $individual->getObject()->getIntensity() * 100;
          break;
        case 'hsi_saturation':
          $new_index = $individual->getObject()->getHsiSaturation() * 100;
          break;
      }

      if (isset($colors[$new_index])) {
        while (isset($colors[$new_index])) {
          $new_index++;
        }
        $colors[$new_index] = clone $individual;
      } else {
        $colors[$new_index] = clone $individual;
      }
    }

    if ($direction === 'ASC') {
      ksort($colors);
    } else {
      krsort($colors);
    }

    $this->individuals = $colors;
  }

  /**
   * @param \Hashbangcode\Wevolution\Evolution\Individual\Individual|NULL $individual
   */
  public function addIndividual(Individual $individual = NULL) {
    if (is_null($individual)) {
      $individual = ColorIndividual::generateRandomColor();
    }

    $this->individuals[] = $individual;
  }
}