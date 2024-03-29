<?php

namespace Hashbangcode\Webolution\Test;

use Hashbangcode\Webolution\Evolution;
use Hashbangcode\Webolution\Type\Color\ColorPopulation;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class EvolutionTest extends TestCase
{
    protected $prophet;

    public function setup(): void
    {
        $this->prophet = new Prophet();
    }

    public function testNotInitializedPopulationIsFullLength()
    {
        $population = new ColorPopulation();
        $evolution = new Evolution($population);

        $population = $evolution->getCurrentPopulation();
        $this->assertEquals($evolution->getIndividualsPerGeneration(), $population->getIndividualCount());
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

        $this->assertEquals(0, $evolution->getCurrentPopulation()->getIndividualCount());
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

        $this->assertEquals(2, $evolution->getCurrentPopulation()->getIndividualCount());

        $evolution->setIndividualsPerGeneration(4);

        $evolution->runGeneration();
        $this->assertEquals(4, $evolution->getCurrentPopulation()->getIndividualCount());
    }

    public function testEvolutionRender()
    {
        $colorPopulation = new ColorPopulation();
        $colorPopulation->addIndividual();
        $colorPopulation->addIndividual();
        $colorPopulation->setDefaultRenderType('cli');

        $this->assertStringContainsString('cli', $colorPopulation->getDefaultRenderType());

        $evolution = new Evolution($colorPopulation, false);

        $evolution->runGeneration();
        $evolution->runGeneration();

        $output = $evolution->renderGenerations(true, 'cli');

        $this->assertStringContainsString('1:', $output);
        $this->assertStringContainsString('2:', $output);
        $this->assertStringContainsString('Min Fitness:', $output);
        $this->assertStringContainsString('Max Fitness:', $output);
    }

    public function testEvolutionColorConstructorParameters()
    {
        $colorPopulation = new ColorPopulation();
        $colorPopulation->addIndividual();

        $evolution = new Evolution($colorPopulation, true, 10, 20);

        $evolution->runGeneration();

        $this->assertEquals(10, $evolution->getMaxGenerations());
        $this->assertEquals(20, $evolution->getIndividualsPerGeneration());
        $this->assertEquals(20, $evolution->getCurrentPopulation()->getIndividualCount());

        $this->assertEquals($evolution->getIndividualsPerGeneration(), $evolution->getCurrentPopulation()->getIndividualCount());
    }

    public function testEvolutionColorAutoGeneratePopulation()
    {
        $colorPopulation = new ColorPopulation();
        $evolution = new Evolution($colorPopulation, true, 10, 20);

        $this->assertEquals(10, $evolution->getMaxGenerations());
        $this->assertEquals(20, $evolution->getIndividualsPerGeneration());
        $this->assertEquals(20, $evolution->getCurrentPopulation()->getIndividualCount());

        $this->assertEquals($evolution->getIndividualsPerGeneration(), $evolution->getCurrentPopulation()->getIndividualCount());
    }

    public function testPopulationCrossoverDoesNotExceedMaxPopulation()
    {
        $colorPopulation = new ColorPopulation();
        $evolution = new Evolution($colorPopulation, false, 10, 20);

        $evolution->getCurrentPopulation()->addIndividual();
        $evolution->getCurrentPopulation()->addIndividual();
        $evolution->getCurrentPopulation()->addIndividual();

        $this->assertEquals(3, $evolution->getCurrentPopulation()->getIndividualCount());

        $evolution->crossOverPopulation();

        $this->assertEquals(20, $evolution->getCurrentPopulation()->getIndividualCount());

        $colorPopulation = new ColorPopulation();
        $evolution = new Evolution($colorPopulation, true, 10, 20);

        $this->assertEquals(20, $evolution->getCurrentPopulation()->getIndividualCount());

        $evolution->crossOverPopulation();

        $this->assertEquals(20, $evolution->getCurrentPopulation()->getIndividualCount());
    }
}
