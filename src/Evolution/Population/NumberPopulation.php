<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;
use Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual;
use Hashbangcode\Wevolution\Type\Number\Number;

/**
 * Class NumberPopulation
 * @package Hashbangcode\Wevolution\Evolution\Population
 */
class NumberPopulation extends Population
{

  /**
   * @param \Hashbangcode\Wevolution\Evolution\Individual\Individual|NULL $individual
   */
  public function addIndividual(Individual $individual = NULL) {
    if (is_null($individual)) {
      $number = rand(1, 10);
      $individual = new NumberIndividual($number);
    }
    $this->individuals[] = $individual;
  }

  /**
   * @return array
   */
  public function getIndividuals() {
    return $this->individuals;
  }

  /**
   *
   */
  public function sort() {
    sort($this->individuals);
  }

  /**
   * @return string
   */
  public function render() {
    $output = parent::render();
    switch ($this->getDefaultRenderType()) {
      case 'html':
        $output .= ' (' . $this->getLength() . ' items)<br>';
        break;
      case 'cli':
        $output .= ' (' . $this->getLength() . ' items)' . PHP_EOL;
        break;
    }
    return $output;
  }
}