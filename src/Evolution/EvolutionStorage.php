<?php
namespace Hashbangcode\Wevolution\Evolution;

use Hashbangcode\Wevolution\Evolution\Population;

class EvolutionStorage extends Evolution {

  protected $databaseName = 'sqlite:database.sqlite';

  /**
   * @return string
   */
  public function getDatabaseName()
  {
    return $this->databaseName;
  }

  /**
   * @param string $databaseName
   */
  public function setDatabaseName($databaseName)
  {
    $this->databaseName = $databaseName;
  }

  public function __construct(Population\Population $population, $maxGenerations = NULL, $individualsPerGeneration = NULL, $autoGeneratePopulation = FALSE) {
    parent::__construct($population, $maxGenerations, $individualsPerGeneration, $autoGeneratePopulation);

    // Create database.
    $db = new \PDO($this->getDatabaseName());

    // Save the initial generation to the database.
  }

  public function runGeneration($kill = TRUE) {

    parent::runGeneration($kill);

    // Save the current generation to a database.
  }

}