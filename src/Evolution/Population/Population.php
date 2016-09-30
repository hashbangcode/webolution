<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;

abstract class Population implements PopulationInterface
{
  /**
   * @var array
   */
  protected $individuals = array();

  /**
   * @var string
   */
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

  /**
   * @return int
   */
  public function getLength() {
    return count($this->individuals);
  }

  abstract public function addIndividual(Individual $individual = NULL);

  /**
   * @return array
   */
  public function getIndividuals() {
    return $this->individuals;
  }

  abstract public function sort();

  /**
   * @return mixed
   */
  public function getRandomIndividual() {
    return $this->individuals[array_rand($this->individuals)];
  }

  /**
   * @param $key
   */
  public function removeIndividual($key) {
    if (isset($this->individuals[$key])) {
      unset($this->individuals[$key]);
    }
  }

  /**
   *
   */
  public function __clone() {
    foreach ($this->individuals as $key => $individual) {
      $newIndividual = clone $individual;
      unset($this->individuals[$key]);
      $this->individuals[$key] = $newIndividual;
    }

    if (is_object($this->medianIndividual)) {
      $meanIndividual = clone $this->medianIndividual;
      $this->medianIndividual = $meanIndividual;
    }

    if (is_object($this->minIndividual)) {
      $minIndividual = clone $this->minIndividual;
      $this->minIndividual = $minIndividual;
    }

    if (is_object($this->maxIndividual)) {
      $maxIndividual = clone $this->maxIndividual;
      $this->maxIndividual = $maxIndividual;
    }
  }

  public function copyIndividual() {
    $this->individuals[] = clone $this->getRandomIndividual();
  }

  /**
   * @return string
   */
  public function render() {
    $output = '';

    // Ensure that the items are sorted.
    $this->sort();

    foreach ($this->getIndividuals() as $individual) {
      $output .= $individual->render($this->getDefaultRenderType());
    }

    return $output;
  }

  protected $populationFitness;
  protected $meanFitness;

  protected $medianIndividual;
  protected $minIndividual;
  protected $maxIndividual;

  public function generateStatistics() {

    // Sort the current population.
    $this->sort();

    foreach ($this->getIndividuals() as $key => $individual) {
      $fitness = $individual->getFitness();

      // Store Max.
      if (!is_object($this->maxIndividual) || $fitness > $this->maxIndividual->getFitness()) {
        $this->maxIndividual = $individual;
      }

      // Store Min.
      if (!is_object($this->minIndividual) || $fitness < $this->minIndividual->getFitness()) {
        $this->minIndividual = $individual;
      }

      $this->populationFitness[] = $fitness;
    }

    // Calculate mean.
    $this->meanFitness = array_sum($this->populationFitness) / $this->getLength();

    // Get Median.
    //$this->medianIndividual = array_slice($this->getIndividuals(), $this->getIndividuals()[floor(($this->getLength() - 1) / 2)], 1);
  }

  public function getStatistics() {
    return [
      'min' => $this->minIndividual,
      'max' => $this->maxIndividual,
      'median' => $this->medianIndividual,
      'meanFitness' => $this->meanFitness,
    ];
  }
}