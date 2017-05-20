<?php

namespace Hashbangcode\Wevolution\Test\Evolution;

use Hashbangcode\Wevolution\Evolution\EvolutionStorage;
use Hashbangcode\Wevolution\Evolution\Population\NumberPopulation;
use Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual;
use Hashbangcode\Wevolution\Evolution\Population\ColorPopulation;

class EvolutionStorageTest extends \PHPUnit_Framework_TestCase
{

    public $databaseFile = 'tests/testdatabase.sqlite';

    public function testEvolutionNumber()
    {
        $numberPopulation = new NumberPopulation();
        $evolution = new EvolutionStorage($numberPopulation);

        $population = $evolution->getCurrentPopulation();
        $this->assertEquals($evolution->getIndividualsPerGeneration(), $population->getLength());
    }

    public function testEvolutionColor()
    {
        $colorPopulation = new ColorPopulation();
        $evolution = new EvolutionStorage($colorPopulation);

        $population = $evolution->getCurrentPopulation();
        $this->assertEquals($evolution->getIndividualsPerGeneration(), $population->getLength());
    }

    public function testEvolutionStorage()
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

        unset($evolution);

        $evolution = new EvolutionStorage();
        $evolution->setEvolutionId(1);
        $evolution->setupDatabase('sqlite:' . $this->databaseFile);
        $evolution->setIndividualsPerGeneration(10);
        $evolution->loadPopulation();
        $evolution->runGeneration();

        $this->assertEquals(3, $evolution->getGeneration());
    }

    public function testClearDatabase()
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
        $this->assertEquals(1, $evolution->getGeneration());
    }

    public function tearDown()
    {
        // Remove any database files that have been created.
        if (file_exists($this->databaseFile)) {
            unlink($this->databaseFile);
        }
    }
}
