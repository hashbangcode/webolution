<?php
namespace Hashbangcode\Wevolution\Evolution;

use Hashbangcode\Wevolution\Evolution\Population;

class Evolution
{

  protected $generation = 1;

  protected $globalMutationFactor;

  /**
   * @return null
   */
  public function getGlobalMutationFactor()
  {
    return $this->globalMutationFactor;
  }

  /**
   * @param null $globalMutationFactor
   */
  public function setGlobalMutationFactor($globalMutationFactor)
  {
    $this->globalMutationFactor = $globalMutationFactor;
  }

  protected $maxGenerations;

  /**
   * @return int|null
   */
  public function getMaxGenerations()
  {
    return $this->maxGenerations;
  }

  /**
   * @param int|null $maxGenerations
   */
  public function setMaxGenerations($maxGenerations)
  {
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

  public function __construct(Population\Population $population, $maxGenerations = NULL, $individualsPerGeneration = NULL, $autoGeneratePopulation = FALSE)
  {
    if (!is_null($maxGenerations)) {
      $this->setMaxGenerations($maxGenerations);
    } else {
      $this->setMaxGenerations(10);
    }

    if (!is_null($individualsPerGeneration)) {
      $this->setIndividualsPerGeneration($individualsPerGeneration);
    } else {
      $this->setMaxGenerations(10);
    }

    $this->population = $population;
    $this->previousGenerations[$this->generation] = clone $this->getCurrentPopulation();

    // Setup initial Population.
    if ($autoGeneratePopulation === TRUE && $this->population->getLength() < $this->getIndividualsPerGeneration()) {
      // Get the population object to generate individuals.
      do {
        $this->population->addIndividual();
      } while ($this->population->getLength() < $this->getIndividualsPerGeneration());
    }
  }

  /**
   * @return Population\Population
   */
  public function getCurrentPopulation()
  {
    return $this->population;
  }

  /**
   * @param Population\Population $population
   */
  public function setPopulation($population)
  {
    $this->population = $population;
  }

  public function addPreviousGeneration($population) {

    $this->previousGenerations[$this->generation] = clone $population;
  }

  /**
   * @return bool
   */
  public function runGeneration()
  {
    // Ensure the population has a length.
    if ($this->population->getLength() == 0) {
      $this->generation = $this->getMaxGenerations();
      return FALSE;
    }

    $this->addPreviousGeneration(clone $this->getCurrentPopulation());

    // Ensure the population is at the right level.
    if ($this->population->getLength() < $this->getIndividualsPerGeneration()) {
      do {
        // Clone an individual from the current population to add back in.
        $random_individual = $this->population->getRandomIndividual();
        if (is_object($random_individual)) {
          //echo 'created: ' . $random_individual->render() . '<br>';
          $this->population->addIndividual(clone $random_individual);
        }
      } while ($this->population->getLength() < $this->getIndividualsPerGeneration());
    }

    // Mutate the population
    foreach ($this->population->getPopulation() as $key => $individual) {
      if (!is_null($this->getGlobalMutationFactor())) {
        $individual->setMutationFactor($this->getGlobalMutationFactor());
      }
      $individual->mutateProperties();
    }

    // Kill off any unfit individuals.
    foreach ($this->population->getPopulation() as $key => $individual) {
      if ($individual->getFitness() < $this->allowedFitness) {
        //echo 'killed:' . $individual->render() . '<br>';
        $this->population->removeIndividual($key);
      }
    }

    $this->generation++;
  }

  public function getGeneration()
  {
    return $this->generation;
  }

  public function renderGenerations()
  {
    $output = '';

    foreach ($this->previousGenerations as $generation_number => $population) {
      $output .= $generation_number . ': ' . $population->render() . PHP_EOL;
    }
    return $output;
  }

  public function getAllowedFitness()
  {
    return $this->allowedFitness();
  }

  public function setAllowedFitness($allowedFitness)
  {
    $this->allowedFitness = $allowedFitness;
  }
}