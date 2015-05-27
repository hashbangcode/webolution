<?php
namespace Hashbangcode\Wevolution\Evolution;

use Hashbangcode\Wevolution\Evolution\Population;

class Evolution
{

  protected $generation = 1;

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

  protected $maxGenerations;

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

  protected $individualsPerGeneration;

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
    else {
      $this->maxGenerations = 10;
    }

    if (!is_null($individualsPerGeneration)) {
      $this->individualsPerGeneration = $individualsPerGeneration;
    } else {
      $this->individualsPerGeneration = 10;
    }

    $this->population = $population;

    // Setup initial Population.
    if ($this->population->getLength() < $this->getIndividualsPerGeneration()) {
      // Get the population object to generate individuals.
      do {
        $this->population->addIndividual();
      } while ($this->population->getLength() < $this->getIndividualsPerGeneration());
    }
  }

  public function getCurrentPopulation() {
    return $this->population;
  }

  public function runGeneration() {

    // Ensure the population has a length.
    if ($this->population->getLength() == 0) {
      $this->generation = $this->getMaxGenerations();
      return FALSE;
    }

    $this->previousGenerations[$this->generation] = clone $this->population;

    // Ensure the population is at the right level.
    if ($this->population->getLength() <= $this->getIndividualsPerGeneration()) {
      do {
        // Clone an individual from the current population to add back in.
        $random_individual = $this->population->getRandomIndividual();
        if (is_object($random_individual)) {
          echo 'created: ' . $random_individual->render() . '<br>';
          $this->population->addIndividual(clone $random_individual);
        }
      } while ($this->population->getLength() <= $this->getIndividualsPerGeneration());
    }

    echo '<br>generation<br>';
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
    $output = '';
    foreach ($this->previousGenerations as $generation_number => $population) {
      $output .= $generation_number . ': ' . $population->render() . PHP_EOL;
    }
    return $output;
  }

  public function getAllowedFitness() {
    return $this->allowedFitness();
  }

  public function setAllowedFitness($allowedFitness) {
    $this->allowedFitness = $allowedFitness;
  }
}