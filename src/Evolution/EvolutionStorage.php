<?php

namespace Hashbangcode\Wevolution\Evolution;

use Hashbangcode\Wevolution\Evolution\Population;

class EvolutionStorage extends Evolution
{

    protected $databaseName = 'sqlite:database.sqlite';

    protected $database;

    protected $evolutionId = null;

    /**
     * EvolutionStorage constructor.
     *
     * @param Population\Population|null $population
     * @param null $maxGenerations
     * @param null $individualsPerGeneration
     * @param bool $autoGeneratePopulation
     */
    public function __construct(Population\Population $population = null, $maxGenerations = null, $individualsPerGeneration = null, $autoGeneratePopulation = false)
    {
        parent::__construct($population, $maxGenerations, $individualsPerGeneration, $autoGeneratePopulation);
    }

    /**
     * @param $databaseName
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

        $stmt = $this->database->prepare("SELECT count(1) AS evolution_count FROM evolution WHERE evolution_id = :evolution_id");

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

    /**
     *
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
  "min_fitness" real NULL
);';
        $this->database->exec($sql);
    }

    /**
     * @return int|null
     */
    public function getEvolutionId()
    {
        if (!is_null($this->evolutionId)) {
            return $this->evolutionId;
        }

        $maxEvolutionId = $this->database->query("SELECT MAX(evolution_id) + 1 AS max_evolution_id FROM evolution")->fetchColumn();

        if (is_null($maxEvolutionId)) {
            $maxEvolutionId = 1;
        }

        $this->evolutionId = $maxEvolutionId;
        return $this->evolutionId;
    }

    /**
     * @param $evolutionId
     */
    public function setEvolutionId($evolutionId)
    {
        $this->evolutionId = $evolutionId;
    }

    /**
     * @param $evolution_id
     */
    private function createEvolution($evolution_id)
    {
        $query = $this->database->prepare('INSERT INTO evolution(evolution_id, current_generation) VALUES(:evolution_id, 1)');
        $query->execute(array('evolution_id' => $evolution_id));
    }

    /**
     * @param $evolution_id
     * @return bool
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
    public function runGeneration($kill = true)
    {
        parent::runGeneration($kill);

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
     * @param $population
     */
    public function storeGeneration($population)
    {
        $sql = 'INSERT INTO populations(population_id, evolution_id) VALUES (:population_id, :evolution_id)';
        $query = $this->database->prepare($sql);
        $query->execute(
            array(
                'population_id' => $this->getGeneration(),
                'evolution_id' => $this->getEvolutionId(),
            )
        );

        foreach ($population->getIndividuals() as $individual) {
            $serializedIndividual = serialize($individual);

            $sql = 'INSERT INTO individuals(evolution_id, population_id, individual) VALUES (:evolution_id, :population_id, :individual)';
            $query = $this->database->prepare($sql);

            $query->execute(
                array(
                    'population_id' => $this->getGeneration(),
                    'evolution_id' => $this->getEvolutionId(),
                    'individual' => $serializedIndividual,
                )
            );
        }
    }

    /**
     * @param Population\Population $population
     */
    public function setPopulation($population)
    {
        $this->population = $population;

        $this->storeGeneration($this->population);
    }

    /**
     *
     */
    public function loadPopulation()
    {
        $sql = "SELECT * FROM individuals WHERE evolution_id = :evolution_id AND population_id = :population_id";

        $stmt = $this->database->prepare($sql);

        if ($stmt == false) {
            return false;
        }

        $stmt->execute(
            array(
                'evolution_id' => $this->getEvolutionId(),
                'population_id' => $this->getGeneration(),
            )
        );
        $population_data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($population_data as $key => $individual_data) {
            $individual = unserialize($individual_data['individual']);

            $this->population->addIndividual($individual);
        }
    }

    /**
     * @return string
     */
    public function renderGenerations($printStats = false)
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
     * Cleares out the database.
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
            $result = $this->database->exec($sql);
        }
    }
}