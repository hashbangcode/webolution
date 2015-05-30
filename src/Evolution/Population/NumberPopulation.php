<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;
use Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual;
use Hashbangcode\Wevolution\Type\Number\Number;

class NumberPopulation extends Population
{

  public function addIndividual(Individual $individual = NULL) {
    if (is_null($individual)) {
      $number = rand(1, 10);
      $individual = new NumberIndividual($number);
    }
    $this->individuals[] = $individual;
  }

  public function getPopulation() {
    return $this->individuals;
  }

  public function sort() {
    sort($this->individuals);
  }

  public function render() {
    $output = '';

    //$this->sort();

    foreach ($this->getPopulation() as $numberIndividual) {
      $output .= $numberIndividual->render() .' ';
    }
    $output .= ' (' . $this->getLength() . ' items)';
    return $output;
  }
}