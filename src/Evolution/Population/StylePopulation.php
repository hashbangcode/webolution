<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;
use Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual;
use Hashbangcode\Wevolution\Type\Style\Style;

/**
 * Class StylePopulation
 * @package Hashbangcode\Wevolution\Evolution\Population
 */
class StylePopulation extends Population {

  /**
   * @return string
   */
  public function render() {
    $output = '';



    return $output;
  }

  /**
   *
   */
  public function sort() {
    // Don't sort style elements.
  }

  /**
   * @param \Hashbangcode\Wevolution\Evolution\Individual\Individual|NULL $individual
   */
  public function addIndividual(Individual $individual = NULL) {
    if (is_null($individual)) {
      $style = new Style();

      $individual = new StyleIndividual($style);
    }

    $this->individuals[] = $individual;
  }
}