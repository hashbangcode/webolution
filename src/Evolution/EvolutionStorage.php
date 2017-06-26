<?php

namespace Hashbangcode\Wevolution\Evolution;

use Hashbangcode\Wevolution\Evolution\Population\Population;

/**
 * Class EvolutionStorage.
 *
 * @package Hashbangcode\Wevolution\Evolution
 */
class EvolutionStorage extends Evolution
{
    /**
     * The filename of the database.
     *
     * @var string
     */
    protected $databaseName = 'sqlite:database.sqlite';

    /**
     * The database connection.
     *
     * @var resource
     */
    protected $database;

    /**
     * The evolution id.
     *
     * @var null
     */
    protected $evolutionId = null;

    /**
     * EvolutionStorage constructor.
     *
     * @param Population|null $population
     *   The population object to get things running.
     * @param int $maxGenerations
     *   The maximum number of generations.
     * @param null $individualsPerGeneration
     *   The minimal number of individuals per generation.
     * @param bool $autoGeneratePopulation
     *   Whether to auto-populate the population.
     */
    public function __construct(
        Population $population = null,
        $autoGeneratePopulation = true,
        $maxGenerations = null,
        $individualsPerGeneration = null
    ) {
        parent::__construct($population, $autoGeneratePopulation, $maxGenerations, $individualsPerGeneration);
    }

    /**
     * Set up the database.
     *
     * @param string $databaseName
     *   The database name.
     */
    public function setupDatabase($databaseName)
    {
        $this->setDatabaseName($databaseName);

        $createDatabase = false;

        if (!file_exists(str_replace('sqlite:', '', $this->databaseName))) {
            $createDatabase = true;
        }

        $this->database = new \PDO($this->getDatabaseName(), '', '', array(\PDO::ATTR_PERSISTENT => false));

        if ($createDatabase == true) {
            $this->createDatabase();
        }

        $sql = "SELECT count(1) AS evolution_count FROM evolution WHERE evolution_id = :evolution_id";
        $stmt = $this->database->prepare($sql);

        $stmt->execute(
            array(
                'evolution_id' => $this->getEvolutionId()
            )
        );

        $evolution_count = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Get or create the evolution item
        if ($evolution_count['evolution_count'] == 0) {
            $this->createEvolution($this->getEvolutionId());
        } else {
            $evolution = $this->retrieveEvolution($this->getEvolutionId());
            $this->generation = (int)$evolution['current_generation'];
        }
    }

    /**
     * Get the database name.
     *
     * @return string
     *   The database name.
     */
    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    /**
     * Set the database name.
     *
     * @param string $databaseName
     *   The database name.
     */
    public function setDatabaseName($databaseName)
    {
        $this->databaseName = $databaseName;
    }

    /**
     * Create the database.
     */
    private function createDatabase()
    {
        $sql = 'DROP TABLE IF EXISTS "evolution";
CREATE TABLE "evolution" (
  "evolution_id" integer NOT NULL,
  "current_generation" integer NOT NULL
);

DROP TABLE IF EXISTS "individuals";
CREATE TABLE "individuals" (
  "individual_id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "evolution_id" integer NOT NULL,
  "population_id" integer NOT NULL,
  "individual" blob NOT NULL
);

DROP TABLE IF EXISTS "populations";
CREATE TABLE "populations" (
  "population_id" integer NOT NULL PRIMARY KEY,
  "evolution_id" integer NOT NULL,
  "max_fitness" real NULL,
  "min_fitness" real NULL,
  "population_type" text NOT NULL
);';
        $this->database->exec($sql);
    }

    /**
     * Get the evolution id.
     *
     * @return int
     *   The evolution id.
     */
    public function getEvolutionId()
    {
        if (!is_null($this->evolutionId)) {
            return $this->evolutionId;
        }

        $sql = "SELECT MAX(evolution_id) + 1 AS max_evolution_id FROM evolution";
        $maxEvolutionId = $this->database->query($sql)->fetchColumn();

        if (is_null($maxEvolutionId)) {
            $maxEvolutionId = 1;
        }

        $this->evolutionId = $maxEvolutionId;
        return $this->evolutionId;
    }

    /**
     * Set the evolution id.
     *
     * @param int $evolutionId
     *   The evolution id.
     */
    public function setEvolutionId($evolutionId)
    {
        $this->evolutionId = $evolutionId;
    }

    /**
     * Create the evolution setup.
     *
     * @param int $evolution_id
     *   The evolution ID to create.
     */
    private function createEvolution($evolution_id)
    {
        $sql = "INSERT INTO evolution(evolution_id, current_generation) VALUES(:evolution_id, 1)";
        $query = $this->database->prepare($sql);
        $query->execute(array('evolution_id' => $evolution_id));
    }

    /**
     * Get the evolution setup.
     *
     * @param int $evolution_id
     *   The evolution setup.
     *
     * @return array
     *   The evolution setup.
     */
    private function retrieveEvolution($evolution_id)
    {
        $sql = "SELECT * FROM evolution WHERE evolution_id = :evolution_id";

        $stmt = $this->database->prepare($sql);

        if ($stmt == false) {
            return false;
        }

        $stmt->execute(
            array(
                'evolution_id' => $evolution_id
            )
        );

        $evolution = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $evolution;
    }

    /**
     * {@inheritdoc}
     */
    public function runGeneration($kill = true, $storeGenerations = true)
    {
        parent::runGeneration($kill, $storeGenerations);

        // Increment generation in database.
        $sql = 'UPDATE evolution SET current_generation = :current_generation WHERE evolution_id = :evolution_id';
        $query = $this->database->prepare($sql);
        $query->execute(
            array(
                'current_generation' => $this->getGeneration(),
                'evolution_id' => $this->getEvolutionId(),
            )
        );

        // Save the current generation to a database.
        $this->storeGeneration($this->getCurrentPopulation());
    }

    /**
     * Store the generation.
     *
     * @param Population $population
     *   Store the population object in the database.
     */
    public function storeGeneration(Population $population)
    {
        // @todo : store statistics.

        // Insert the population into the database.
        $sql = 'INSERT INTO populations(population_id, evolution_id, population_type) ';
        $sql .= ' VALUES (:population_id, :evolution_id, :population_type)';
        $query = $this->database->prepare($sql);
        $query->execute(
            array(
                'population_id' => $this->getGeneration(),
                'evolution_id' => $this->getEvolutionId(),
                'population_type' => get_class($population),
            )
        );

        $individuals = [];

        foreach ($population->getIndividuals() as $key => $individual) {
            $serializedIndividual = serialize($individual);

            $sql = 'INSERT INTO individuals(evolution_id, population_id, individual) ';
            $sql .= 'VALUES (:evolution_id, :population_id, :individual)';
            $query = $this->database->prepare($sql);

            $query->execute(
                array(
                    'population_id' => $this->getGeneration(),
                    'evolution_id' => $this->getEvolutionId(),
                    'individual' => $serializedIndividual,
                )
            );

            $newId = $this->database->lastInsertId();
            $individuals[$newId] = $individual;
        }

        // Set the new individuals for the population.
        $population->setIndividuals($individuals);
    }

    /**
     * Set the population.
     *
     * This also stores the population.
     *
     * @param Population\Population $population
     *   The population.
     */
    public function setPopulation($population)
    {
        $this->population = $population;

        $this->storeGeneration($this->population);
    }

    /**
     * Load a population from the database into the Evolution object.
     */
    public function loadPopulation()
    {
        if (!($this->population instanceof \Hashbangcode\Wevolution\Evolution\Population\Population)) {
            // If the population isn't set then attempt to load it from the database.
            $populationSql = "SELECT * FROM populations ";
            $populationSql .= "WHERE evolution_id = :evolution_id AND population_id = :population_id";
            $populationStatement = $this->database->prepare($populationSql);
            $populationStatement->execute(
                array(
                    'evolution_id' => $this->getEvolutionId(),
                    'population_id' => $this->getGeneration(),
                )
            );
            $population_data = $populationStatement->fetchAll(\PDO::FETCH_ASSOC);

            if (count($population_data) > 0) {
                // We have a population result so create it.
                $population_data = array_pop($population_data);
                $populationType = '\\' . $population_data['population_type'];
                if (class_exists($populationType)) {
                    $this->population = new $populationType;
                }
            }
        }

        // Query the database for individuals of the population.
        $individualSql = "SELECT * FROM individuals ";
        $individualSql .= "WHERE evolution_id = :evolution_id AND population_id = :population_id";
        $individualStatement = $this->database->prepare($individualSql);

        if ($individualStatement == false) {
            return false;
        }

        $individualStatement->execute(
            array(
                'evolution_id' => $this->getEvolutionId(),
                'population_id' => $this->getGeneration(),
            )
        );

        $individuals = [];

        // Load the individuals from the database and add them to the population.
        $individualData = $individualStatement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($individualData as $key => $data) {
            $individual = unserialize($data['individual']);
            $individuals[$data['individual_id']] = $individual;
        }

        $this->population->setIndividuals($individuals);
    }

    /**
     * {@inheritdoc}
     */
    public function renderGenerations($printStats = false, $format = 'html')
    {
        $output = '';

        foreach ($this->previousGenerations as $generation_number => $population) {
            $output .= $population->render() . PHP_EOL . '<br>';
            if ($printStats === true) {
                $stats = $population->getStatistics();
                $output .= 'MIN: ' . print_r($stats['min']->render(), true) . '<br>';
                $output .= 'MAX: ' . print_r($stats['max']->render(), true) . '<br>';
            }
        }
        return $output;
    }

    /**
     * Utility function to cleare out the database.
     */
    public function clearDatabase()
    {
        $tables = [
            'evolution',
            'individuals',
            'populations',
        ];

        foreach ($tables as $table) {
            $sql = 'DELETE FROM ' . $table;
            $this->database->exec($sql);
        }
    }
}
