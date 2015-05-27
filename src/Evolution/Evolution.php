<?php
namespace Hashbangcode\Wevolution\Evolution;

use Hashbangcode\Wevolution\Evolution\Population;

class Evolution
{

  protected $globalMutationFactor = null;

  /**
   * @return null
   */
  public function getGlobalMutationFactor() {
    return $this->globalMutationFactor;
  }

  /**
   * @param null $globalMutationFactor
   */
  public function setGlobalMutationFactor($globalMutationFactor) {
    $this->globalMutationFactor = $globalMutationFactor;
  }

  protected $maxGenerations = 10;

  /**
   * @return int|null
   */
  public function getMaxGenerations() {
    return $this->maxGenerations;
  }

  /**
   * @param int|null $maxGenerations
   */
  public function setMaxGenerations($maxGenerations) {
    $this->maxGenerations = $maxGenerations;
  }

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

    if ($this->population->getLength() == 0) {
      return FALSE;
    }

    // Ensure the population is at the right level.
    if ($this->population->getLength() <= $this->getIndividualsPerGeneration()) {
      do {
        // Clone an individual from the current population to add back in.
        $random_individual = $this->population->getRandomIndividual();
        $this->population->addIndividual(clone $random_individual);
      } while ($this->population->getLength() <= $this->getIndividualsPerGeneration());
    }

    // Mutate the population
    foreach ($this->population->getPopulation() as $key => $individual) {
      if (!is_null($this->getGlobalMutationFactor())) {
        $individual->setMutationFactor($this->getGlobalMutationFactor());
      }
      $individual->mutateProperties();
    }

    // Kill off any unfit individuals
    foreach ($this->population->getPopulation() as $key => $individual) {
      if ($individual->getFitness() < $this->allowedFitness) {
        echo 'killed:' . $individual->render() . '<br>';
        $this->population->removeIndividual($key);
      }
    }

    $this->generation++;
  }

  public function getCurrentGeneration() {
    return $this->generation;
  }

  public function renderGenerations() {
    foreach ($this->previousGenerations as $generation) {
      $generation->render() . PHP_EOL;
    }
  }

  public function getAllowedFitness() {
    return $this->allowedFitness();
  }

  public function setAllowedFitness($allowedFitness) {
    $this->allowedFitness = $allowedFitness;
  }
}