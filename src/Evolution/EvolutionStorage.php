<?php
namespace Hashbangcode\Wevolution\Evolution;

use Hashbangcode\Wevolution\Evolution\Population;

class EvolutionStorage extends Evolution {

  public function __construct(Population\Population $population, $maxGenerations = NULL, $individualsPerGeneration = NULL, $autoGeneratePopulation = FALSE) {
    parent::__construct($population, $maxGenerations, $individualsPerGeneration, $autoGeneratePopulation);

    // Save the initial generation to the database.
  }

  public function runGeneration($kill = TRUE) {

    parent::runGeneration($kill);

    // Save the current generation to a database.
  }

}