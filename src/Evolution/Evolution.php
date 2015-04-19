<?php
namespace Hashbangcode\Wevolution\Evolution;

abstract class Evolution implements EvolutionInterface
{

  protected $generation = 0;

  protected $maxGenerations = 20;

  public function __construct($maxGenerations = 20, $individualsPerGeneration = 5) {
    $this->maxGenerations = $maxGenerations;
    $this->individualsPerGeneration = $individualsPerGeneration;
  }

  abstract public function runGeneration();

  public function getCurrentGeneration() {
    return $this->generation;
  }
}