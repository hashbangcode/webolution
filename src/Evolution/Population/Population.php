<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;

abstract class Population implements PopulationInterface
{

  protected $length = 0;

  protected $individuals = array();

  public function getLength() {
    return $this->length;
  }

  abstract public function addIndividual(Individual $individual = NULL);

  public function getPopulation() {
    return $this->individuals;
  }

  abstract public function sort();
}