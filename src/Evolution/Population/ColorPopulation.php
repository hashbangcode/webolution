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
   * @var ColorIndividual
   */
  protected $individual;

  /**
   * Sort the population by a given parameter and in a certain direction.
   *
   * @param string $sortBy
   * @param string $direction
   */
  public function sort($sortBy = 'hue', $direction = 'ASC') {
    
    usort($this->individuals, function ($a, $b) use($sortBy, $direction) {
      switch ($sortBy) {
        case 'hue':
          $aValue = $a->getObject()->getHue();
          $bValue = $b->getObject()->getHue();
          break;
        case 'intensity':
          $aValue = $a->getObject()->getIntensity();
          $bValue = $b->getObject()->getIntensity();
          break;
        case 'hsi_saturation':
          $aValue = $a->getObject()->getHsiSaturation();
          $bValue = $b->getObject()->getHsiSaturation();
          break;
        case 'lightness':
          $aValue = $a->getObject()->getLightness();
          $bValue = $b->getObject()->getLightness();
          break;
        case 'fitness':
          $aValue = $a->getFitness();
          $bValue = $b->getFitness();
      }

      if ($aValue == $bValue) {
        return 0;
      }

      if ($direction == 'ASC') {
        return ($aValue < $bValue) ? -1 : 1;
      }
      else {
        return ($aValue > $bValue) ? -1 : 1;
      }
    });
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