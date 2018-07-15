<?php

namespace Hashbangcode\Wevolution\Test\Evolution;

use Hashbangcode\Wevolution\Evolution\EvolutionStorage;
use Hashbangcode\Wevolution\Evolution\Population\ColorPopulation;
use Prophecy\Prophet;

class EvolutionStorageTest extends \PHPUnit_Framework_TestCase
{
    protected $prophet;

    public $databaseFile = 'tests/testdatabase.sqlite';

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testEmptyEvolutionStorageIsEmpty()
    {
        $evolution = new EvolutionStorage();
        $evolution->setupDatabase('sqlite:' . $this->databaseFile);
        $this->assertEquals(null, $evolution->getCurrentPopulation());
    }

    public function testResumeEvolutionFromScratch()
    {
        $evolution = new EvolutionStorage();
        $evolution->setEvolutionId(1);
        $evolution->setupDatabase('sqlite:' . $this->databaseFile);
        $evolution->setIndividualsPerGeneration(10);

        $population = new ColorPopulation();
        $population->addIndividual();
        $evolution->setPopulation($population);

        $evolution->runGeneration();

        unset($evolution);

        $evolution = new EvolutionStorage();
        $evolution->setEvolutionId(1);
        $evolution->setupDatabase('sqlite:' . $this->databaseFile);
        $evolution->setIndividualsPerGeneration(10);
        $evolution->loadPopulation();
        $evolution->runGeneration();

        $this->assertEquals(2, $evolution->getGeneration());
    }

    public function testClearingTheDatabaseMeansStartingAgain()
    {
        $evolution = new EvolutionStorage();
        $evolution->setEvolutionId(1);
        $evolution->setupDatabase('sqlite:' . $this->databaseFile);
        $evolution->setIndividualsPerGeneration(10);

        $population = new ColorPopulation();
        $population->setDefaultRenderType('html');

        $population->addIndividual();
        $evolution->setPopulation($population);

        $evolution->runGeneration();

        $evolution->clearDatabase();

        unset($evolution);
        unset($population);

        $evolution = new EvolutionStorage();
        $evolution->setEvolutionId(1);
        $evolution->setupDatabase('sqlite:' . $this->databaseFile);
        $this->assertNull($evolution->getCurrentPopulation());
        $this->assertEquals(0, $evolution->getGeneration());
    }

    public function testGettingEvolutionIdGetsANewId()
    {
        $evolution1 = new EvolutionStorage();
        $evolution1->setupDatabase('sqlite:' . $this->databaseFile);
        $evolution1->setEvolutionId(1);

        $evolution2 = new EvolutionStorage();
        $evolution2->setupDatabase('sqlite:' . $this->databaseFile);
        $newEvolutionId = $evolution2->getEvolutionId();

        $this->assertEquals(2, $newEvolutionId);
    }

    public function tearDown()
    {
        // Remove any database files that have been created.
        if (file_exists($this->databaseFile)) {
            unlink($this->databaseFile);
        }
    }
}
