<?php

namespace Hashbangcode\Wevolution\Evolution;

use Hashbangcode\Wevolution\Evolution\Population;

class EvolutionStorage extends Evolution {

  protected $databaseName = 'sqlite:database.sqlite';

  protected $database;

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

  public function __construct($databaseName, Population\Population $population = NULL, $maxGenerations = NULL, $individualsPerGeneration = NULL, $autoGeneratePopulation = FALSE) {
    parent::__construct($population, $maxGenerations, $individualsPerGeneration, $autoGeneratePopulation);

    $this->setDatabaseName($databaseName);

    $this->database = new \PDO($this->getDatabaseName());
    
    $count = $this->database->query("SELECT count(1) FROM evolution");

    // Get or create the evolution item
    if ($count == false) {
      $this->createDatabase();
      $this->createEvolution(1);
      // Save the initial generation to the database.
      // $this->storeGeneration($this->previousGenerations[$this->generation]);
    } else {
      $evolution = $this->retrieveEvolution(1);
      $this->generation = $evolution['current_generation'];
    }
  }

  private function storeGeneration($population) {


  }

  private function retrieveEvolution($evolution_id) {

    $sql = "SELECT * FROM evolution WHERE evolution_id = :evolution_id";

    $stmt = $this->database->prepare($sql);

    if ($stmt == false) {
      return false;
    }

    $stmt->execute(array('evolution_id' => $evolution_id));
    return $stmt->fetch();
  }

  private function createEvolution($evolution_id) {
    $query = $this->database->prepare('INSERT INTO evolution(evolution_id, current_generation) VALUES(:evolution_id, 1)');
    $query->execute(array('evolution_id' => $evolution_id));
  }

  public function runGeneration($kill = TRUE) {

    parent::runGeneration($kill);

    // Save the current generation to a database.
  }

  private function createDatabase() {
    $sql = 'DROP TABLE IF EXISTS "evolution";
CREATE TABLE "evolution" (
  "evolution_id" integer NOT NULL,
  "current_generation" integer NOT NULL
);


DROP TABLE IF EXISTS "individuals";
CREATE TABLE "individuals" (
  "individual_id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "data" blob NOT NULL
);


DROP TABLE IF EXISTS "populations";
CREATE TABLE "populations" (
  "population_id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "max_fitness" real NOT NULL,
  "min_fitness" real NOT NULL
);';
    $this->database->exec($sql);
  }

}