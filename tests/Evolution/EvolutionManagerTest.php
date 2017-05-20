<?php

namespace Hashbangcode\Wevolution\Test\Evolution;

use Hashbangcode\Wevolution\Evolution\EvolutionManager;
use Hashbangcode\Wevolution\Evolution\Population\NumberPopulation;

class EvolutionManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateObject()
    {
        $object = new EvolutionManager();
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Evolution', $object->getEvolutionObject());
    }

    public function testSetEvolutionOption()
    {
        $object = new EvolutionManager();
        $object->getEvolutionObject()->setMaxGenerations(10);
        $this->assertEquals(10, $object->getEvolutionObject()->getMaxGenerations());
    }

    public function testSetupEvolution()
    {
        $object = new EvolutionManager();
        $object->setUpEvolution(10);
        $this->assertEquals(10, $object->getEvolutionObject()->getIndividualsPerGeneration());
    }

    public function testRunEmptyEvolution()
    {
        $object = new EvolutionManager();
        $message = 'No population object exists in evolution class.';
        $this->setExpectedException('Hashbangcode\Wevolution\Evolution\Exception\NoPopulationException', $message);
        $object->runEvolution();
    }

    public function testRunEvolution()
    {
        $object = new EvolutionManager();
        $population = new NumberPopulation();
        $population->addIndividual();
        $object->getEvolutionObject()->setPopulation($population);
        $object->runEvolution();
    }
}
