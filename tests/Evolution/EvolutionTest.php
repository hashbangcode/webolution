<?php

namespace Hashbangcode\Wevolution\Test\Evolution;

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\ColorPopulation;
use Prophecy\Prophet;

class EvolutionTest extends \PHPUnit_Framework_TestCase
{
    protected $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testNotInitializedPopulationIsFullLength()
    {
        $population = new ColorPopulation();
        $evolution = new Evolution($population);

        $population = $evolution->getCurrentPopulation();
        $this->assertEquals($evolution->getIndividualsPerGeneration(), $population->getLength());
    }

    public function testGenerationIsOneWhenFirstCreated()
    {
        $colorPopulation = new ColorPopulation();
        $evolution = new Evolution($colorPopulation);
        $this->assertEquals(1, $evolution->getGeneration());
    }

    public function testEvolutionRunGeneration()
    {
        $colorPopulation = new ColorPopulation();
        $colorPopulation->addIndividual();
        $evolution = new Evolution($colorPopulation);

        $evolution->runGeneration();

        $this->assertEquals(2, $evolution->getGeneration());
    }

    public function testEvolutionSetPopulation()
    {
        $colorPopulation = new ColorPopulation();
        $evolution = new Evolution();

        $evolution->setPopulation($colorPopulation);

        $this->assertEquals(0, $evolution->getCurrentPopulation()->getLength());
    }

    public function testEvolutionRunBlankGeneration()
    {
        $colorPopulation = new ColorPopulation();
        $evolution = new Evolution($colorPopulation, false);

        $this->assertFalse($evolution->runGeneration());
    }

    public function testEvolutionAllowedFitness()
    {
        $colorPopulation = new ColorPopulation();
        $evolution = new Evolution($colorPopulation);

        $evolution->setAllowedFitness(1);

        $this->assertEquals(1, $evolution->getAllowedFitness());
    }

    public function testEvolutionMaxGenerations()
    {
        $colorPopulation = new ColorPopulation();
        $evolution = new Evolution($colorPopulation);

        $evolution->setMaxGenerations(10);

        $this->assertEquals(10, $evolution->getMaxGenerations());
    }

    public function testEvolutionGlobalFitnessFactor()
    {
        $colorPopulation = new ColorPopulation();
        $evolution = new Evolution($colorPopulation);

        $evolution->setGlobalMutationFactor(2);

        $this->assertEquals(2, $evolution->getGlobalMutationFactor());
    }

    public function testEvolutionGlobalFitnessGoal()
    {
        $colorPopulation = new ColorPopulation();
        $evolution = new Evolution($colorPopulation);

        $evolution->setGlobalFitnessGoal('test');

        $this->assertEquals('test', $evolution->getGlobalFitnessGoal());
    }

    public function testEvolutionIndividualsPerGeneration()
    {
        $colorPopulation = new ColorPopulation();
        $evolution = new Evolution($colorPopulation);

        $evolution->setIndividualsPerGeneration(2);

        $this->assertEquals(2, $evolution->getIndividualsPerGeneration());
    }

    public function testEvolutionRunWithIndividualsLimit()
    {
        $colorPopulation = new ColorPopulation();
        $colorPopulation->addIndividual();
        $colorPopulation->addIndividual();

        $evolution = new Evolution($colorPopulation, false);

        $evolution->setIndividualsPerGeneration(4);

        $evolution->runGeneration();
        $this->assertEquals(4, $evolution->getCurrentPopulation()->getLength());
    }


    public function testEvolutionRender()
    {
        $colorPopulation = new ColorPopulation();
        $colorPopulation->addIndividual();
        $colorPopulation->addIndividual();
        $colorPopulation->setDefaultRenderType('cli');

        $evolution = new Evolution($colorPopulation, false);

        $evolution->runGeneration();
        $evolution->runGeneration();

        $output = $evolution->renderGenerations(true, 'cli');

        $this->assertContains('1:', $output);
        $this->assertContains('2:', $output);
        $this->assertContains('Min Fitness:', $output);
        $this->assertContains('Max Fitness:', $output);
    }

    public function testEvolutionColorConstructorParameters()
    {
        $colorPopulation = new ColorPopulation();
        $colorPopulation->addIndividual();

        $evolution = new Evolution($colorPopulation, true, 10, 20);

        $evolution->runGeneration();

        $this->assertEquals(10, $evolution->getMaxGenerations());
        $this->assertEquals(20, $evolution->getIndividualsPerGeneration());

        $this->assertEquals($evolution->getIndividualsPerGeneration(), $evolution->getCurrentPopulation()->getLength());
    }

    public function testEvolutionColorAutoGeneratePopulation()
    {
        $colorPopulation = new ColorPopulation();
        $evolution = new Evolution($colorPopulation, true, 10, 20);

        $this->assertEquals(10, $evolution->getMaxGenerations());
        $this->assertEquals(20, $evolution->getIndividualsPerGeneration());

        $this->assertEquals($evolution->getIndividualsPerGeneration(), $evolution->getCurrentPopulation()->getLength());
    }
}
