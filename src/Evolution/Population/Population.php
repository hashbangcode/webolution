<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;

abstract class Population implements PopulationInterface
{
  protected $individuals = array();

  public function getLength() {
    return count($this->individuals);
  }

  abstract public function addIndividual(Individual $individual = NULL);

  public function getPopulation() {
    return $this->individuals;
  }

  abstract public function sort();

  public function getRandomIndividual() {
    return $this->individuals[array_rand($this->individuals)];
  }

  public function removeIndividual($key) {
    if (isset($this->individuals[$key])) {
      unset($this->individuals[$key]);
    }
  }
}