<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;

/**
 * Class Population
 * @package Hashbangcode\Wevolution\Evolution\Population
 */
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
   * @var array
   */
  protected $populationFitness = array();

  /**
   * @var
   */
  protected $meanFitness;

  /**
   * @var
   */
  protected $medianIndividual;

  /**
   * @var
   */
  protected $minIndividual;

  /**
   * @var
   */
  protected $maxIndividual;

  /**
   * @param Individual|NULL $individual
   * @return mixed
   */
  abstract public function addIndividual(Individual $individual = NULL);

  /**
   * @param $key
   */
  public function removeIndividual($key)
  {
    if (isset($this->individuals[$key])) {
      unset($this->individuals[$key]);
    }
  }

  /**
   *
   */
  public function __clone()
  {
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

  /**
   *
   */
  public function copyIndividual()
  {
    $individual = $this->getRandomIndividual();
    if ($individual !== FALSE) {
      $this->individuals[] = clone $individual;
    }
  }

  /**
   * @return mixed
   */
  public function getRandomIndividual()
  {
    if ($this->getLength() == 0) {
      return FALSE;
    }

    $random_key = array_rand($this->individuals);
    if (!is_null($random_key)) {
      return $this->individuals[$random_key];
    }

    return FALSE;
  }

  /**
   * @return int
   */
  public function getLength()
  {
    return count($this->individuals);
  }

  /**
   * @return string
   */
  public function render()
  {
    $output = '';

    // Ensure that the items are sorted.
    $this->sort();

    foreach ($this->getIndividuals() as $individual) {
      $output .= $individual->render($this->getDefaultRenderType());
    }

    return $output;
  }

  /**
   * @return mixed
   */
  abstract public function sort();

  /**
   * @return array
   */
  public function getIndividuals()
  {
    return $this->individuals;
  }

  /**
   * @return string
   */
  public function getDefaultRenderType()
  {
    return $this->defaultRenderType;
  }

  /**
   * @param string $defaultRender
   */
  public function setDefaultRenderType($defaultRenderType)
  {
    $this->defaultRenderType = $defaultRenderType;
  }

  /**
   * @return bool
   */
  public function generateStatistics()
  {

    if ($this->getLength() == 0) {
      // No population yet.
      return FALSE;
    }

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

  /**
   * @return array
   */
  public function getStatistics()
  {
    return [
      'min' => $this->minIndividual,
      'max' => $this->maxIndividual,
      'median' => $this->medianIndividual,
      'meanFitness' => $this->meanFitness,
    ];
  }
}