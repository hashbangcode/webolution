<?php
namespace Hashbangcode\Wevolution\Evolution;

abstract class Evolution implements EvolutionInterface
{
  protected $individualsPerGeneration = 10;

  protected $individuals = array();

  protected $previousGenerations = array();

  public function __construct($maxGenerations = NULL, $individualsPerGeneration = NULL)
  {
    if (!is_null($maxGenerations)) {
      $this->maxGenerations = $maxGenerations;
    }

    if (!is_null($individualsPerGeneration)) {
      $this->individualsPerGeneration = $individualsPerGeneration;
    }
  }

  abstract public function runGeneration();

  public function getCurrentGeneration() {
    return $this->generation;
  }

  public function renderGenerations() {
    foreach ($this->previousGenerations as $generation) {

    }
  }
}