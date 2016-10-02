<?php
namespace Hashbangcode\Wevolution\Evolution;

use Hashbangcode\Wevolution\Evolution\Population;

class Evolution {

  /**
   * @var int
   */
  protected $generation = 1;

  /**
   * @var
   */
  protected $globalMutationFactor;
  /**
   * @var
   */
  protected $maxGenerations;
  protected $individualsPerGeneration;
  protected $allowedFitness = 8;
  /**
   * @var Population\Population
   */
  protected $population;
  /**
   * @var array
   */
  protected $previousGenerations = array();

  /**
   * Evolution constructor.
   * @param \Hashbangcode\Wevolution\Evolution\Population\Population $population
   * @param null $maxGenerations
   * @param null $individualsPerGeneration
   * @param bool $autoGeneratePopulation
   */
  public function __construct(Population\Population $population, $maxGenerations = NULL, $individualsPerGeneration = NULL, $autoGeneratePopulation = FALSE) {
    if (!is_null($maxGenerations)) {
      $this->setMaxGenerations($maxGenerations);
    }
    else {
      $this->setMaxGenerations(10);
    }

    if (!is_null($individualsPerGeneration)) {
      $this->setIndividualsPerGeneration($individualsPerGeneration);
    }
    else {
      $this->setMaxGenerations(10);
    }

    $this->population = $population;
    $this->population->generateStatistics();
    $this->previousGenerations[$this->generation] = clone $this->getCurrentPopulation();

    // Setup initial Population.
    if ($autoGeneratePopulation === TRUE && $this->population->getLength() < $this->getIndividualsPerGeneration()) {
      // Get the population object to generate individuals.
      do {
        // @todo we should be cloning and then mutating these things if there is at least one individual present instead of just creating new ones.
        $this->population->addIndividual();
      } while ($this->population->getLength() < $this->getIndividualsPerGeneration());
    }
  }

  /**
   * @return Population\Population
   */
  public function getCurrentPopulation() {
    return $this->population;
  }

  /**
   * @return int|null
   */
  public function getIndividualsPerGeneration() {
    return $this->individualsPerGeneration;
  }

  /**
   * @param int|null $individualsPerGeneration
   */
  public function setIndividualsPerGeneration($individualsPerGeneration) {
    $this->individualsPerGeneration = $individualsPerGeneration;
  }

  /**
   * @param Population\Population $population
   */
  public function setPopulation($population) {
    $this->population = $population;
  }

  /**
   * @return bool
   */
  public function runGeneration($kill = TRUE) {
    // Ensure the population has a length.
    if ($this->population->getLength() == 0) {
      // If there is no population left then set the number of generations to max.
      $this->generation = $this->getMaxGenerations();
      return FALSE;
    }

    $this->generation++;

    // Generate statistics before we do anything with the population.
    $this->population->generateStatistics();

    // kill off anything that we don't want

    if ($kill) {
      // Kill off any unfit individuals.
      foreach ($this->population->getIndividuals() as $key => $individual) {

        $fitness = $individual->getFitness();
        $maxFitness =  $this->population->getStatistics()['max']->getFitness();

        // Figure out if this individual is close to the top of the list.
        if ($maxFitness != 0) {
          $fitnessFactor = ($fitness / $maxFitness) * 100;
        } else {
          $fitnessFactor = 0;
        }

        // The higher the allowed fitness then the greater the chance that the individual will survive.
        //$f = $key / $this->population->getLength();
        $rand = (pow(mt_rand(-1, 1), 3)+1)/2 * 100; //cube function
        $keepAlive = ($fitnessFactor >= $rand);

        //echo 'individual:' . $individual->render() . ' fitness:' . $fitness . ' max fitness:' . $maxFitness .' fitness factor:' . $fitnessFactor .'<br>';
        //echo 'kill: ' . ($fitnessFactor * mt_rand(0,1)) .' <strong>' .(mt_rand(0,1) * $fitnessFactor). '</strong><br>';
        //echo 'rand: '.$rand .' ' .var_export($keepAlive, true) . '<br>';

        if (!$keepAlive) {
          $this->population->removeIndividual($key);
        }
      }
    }

   // echo '<br>';

    if ($this->population->getLength() == 0) {
      // If there is no population left then set the number of generations to max.
      $this->generation = $this->getMaxGenerations();
      return FALSE;
    }


    // Ensure the population is at the right level.
    if ($this->population->getLength() < $this->getIndividualsPerGeneration()) {
      do {
        // Clone an individual from the current population to add back in.
        $random_individual = $this->population->getRandomIndividual();
        if (is_object($random_individual)) {
          $this->population->addIndividual(clone $random_individual);
        }
        else {
          // Add a radnom individual (not cloned from the current population).
          $this->population->addIndividual();
        }
      } while ($this->population->getLength() < $this->getIndividualsPerGeneration());
    }

    //print 'PRE TEST: <pre>'.print_r($this->population->getStatistics(), true) . '</pre>';

    // Mutate the population.
    // @todo should this be part of the population class?
    foreach ($this->population->getIndividuals() as $key => $individual) {
      if (!is_null($this->getGlobalMutationFactor())) {
        $individual->setMutationFactor($this->getGlobalMutationFactor());
      }
      $individual->mutateProperties();
    }

    // Store the current generation.
    $this->addPreviousGeneration(clone $this->getCurrentPopulation());

    return TRUE;
  }

  /**
   * @return string
   */
  public function renderGenerations() {
    $output = '';

    foreach ($this->previousGenerations as $generation_number => $population) {
      $output .= $generation_number . ': ' . $population->render() . PHP_EOL;
      $stats = $population->getStatistics();
      //$output .= 'MIN: ' . print_r($stats['min']->render(), TRUE) . '<br>';
      //$output .= 'MAX: ' . print_r($stats['max']->render(), TRUE) . '<br>';
    }
    return $output;
  }

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

  /**
   * @param $population
   */
  public function addPreviousGeneration($population) {
    $this->previousGenerations[$this->generation] = clone $population;
  }

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

  /**
   * @return int
   */
  public function getGeneration() {
    return $this->generation;
  }

  /**
   * @return mixed
   */
  public function getAllowedFitness() {
    return $this->allowedFitness();
  }

  /**
   * @param $allowedFitness
   */
  public function setAllowedFitness($allowedFitness) {
    $this->allowedFitness = $allowedFitness;
  }
}