<?php
namespace Hashbangcode\Wevolution\Evolution;

use Hashbangcode\Wevolution\Evolution\Population;

class Evolution
{
  protected $individualsPerGeneration = 10;

  /**
   * @return int|null
   */
  public function getIndividualsPerGeneration()
  {
    return $this->individualsPerGeneration;
  }

  /**
   * @param int|null $individualsPerGeneration
   */
  public function setIndividualsPerGeneration($individualsPerGeneration)
  {
    $this->individualsPerGeneration = $individualsPerGeneration;
  }

  protected $allowedFitness = 8;

  /**
   * @var Population\Population
   */
  protected $population;

  protected $previousPopulations = array();

  public function __construct(Population\Population $population, $maxGenerations = NULL, $individualsPerGeneration = NULL)
  {
    if (!is_null($maxGenerations)) {
      $this->maxGenerations = $maxGenerations;
    }

    if (!is_null($individualsPerGeneration)) {
      $this->individualsPerGeneration = $individualsPerGeneration;
    }

    $this->population = $population;

    // Setup initial Population.
    if ($this->population->getLength() < $this->individualsPerGeneration) {
      // Get the population object to generate individuals.
      do {
        $this->population->addIndividual();
      } while ($this->population->getLength() < $this->individualsPerGeneration);
    }
  }

  public function getCurrentPopulation() {
    return $this->population;
  }

  public function runGeneration() {

    $this->previousGenerations[] = clone $this->population;

    echo ' start ';

    foreach ($this->population->getPopulation() as $key => $individual) {
      print $individual->toString() . ' ';
    }

    // Ensure the population is at the right level.
    if ($this->population->getLength() <= $this->individualsPerGeneration) {
      echo ' more ';
      do {
        // Clone an individual from the current population to add back in.
        $this->population->addIndividual(clone $this->population->getRandomIndividual());
      } while ($this->population->getLength() <= $this->individualsPerGeneration);
      echo ' (' . $this->population->getLength() . ') ';
    }

    // Mutate the population
    foreach ($this->population->getPopulation() as $key => $individual) {
      $individual->mutateProperties();
    }

    // Kill off any unfit individuals
    foreach ($this->population->getPopulation() as $key => $individual) {
      if ($individual->getFitness() < $this->allowedFitness) {
        //echo 'killed! ' . $individual->getFitness();
        $this->population->removeIndividual($key);
      }
    }

    echo ' end ';

    foreach ($this->population->getPopulation() as $key => $individual) {
      print $individual->toString() . ' ';
    }

    $this->generation++;
  }

  public function getCurrentGeneration() {
    return $this->generation;
  }

  public function renderGenerations() {
    foreach ($this->previousGenerations as $generation) {

    }
  }

  public function getAllowedFitness() {
    return $this->allowedFitness();
  }

  public function setAllowedFitness($allowedFitness) {
    $this->allowedFitness = $allowedFitness;
  }
}