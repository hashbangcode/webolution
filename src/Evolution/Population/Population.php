<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;

abstract class Population implements PopulationInterface
{
  protected $individuals = array();
  protected $defaultRenderType = '';

  /**
   * @return string
   */
  public function getDefaultRenderType() {
    return $this->defaultRenderType;
  }

  /**
   * @param string $defaultRender
   */
  public function setDefaultRenderType($defaultRenderType) {
    $this->defaultRenderType = $defaultRenderType;
  }

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

  public function __clone() {
    foreach ($this->individuals as $key => $individual) {
      $newIndividual = clone $individual;
      unset($this->individuals[$key]);
      $this->individuals[$key] = $newIndividual;
    }
  }

  public function render() {
    $output = '';

    $this->sort();

    foreach ($this->getPopulation() as $individual) {
      $output .= $individual->render($this->getDefaultRenderType());
    }

    return $output;
  }
}