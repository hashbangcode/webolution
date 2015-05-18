<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;
use Hashbangcode\Wevolution\Type\Number\Number;

class NumberPopulation extends Population
{
  public function getLength() {
    return $this->length;
  }

  public function addIndividual(Individual $individual = NULL) {
    if (is_null($individual)) {
      $number = rand(1, 10);
      $individual = new Number($number);
    }
    $this->individuals[] = $individual;
    $this->length++;
  }

  public function getPopulation() {
    return $this->individuals;
  }

  public function sort() {
    sort($this->individuals);
  }
}