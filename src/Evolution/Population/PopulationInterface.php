<?php

namespace Hashbangcode\Wevolution\Evolution\Population;
use Hashbangcode\Wevolution\Evolution\Individual\Individual;

interface PopulationInterface {

  public function addIndividual(Individual $individual = NULL);
  public function sort();
  public function getLength();
  public function getPopulation();
  public function render();
}