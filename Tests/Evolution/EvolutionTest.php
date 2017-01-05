<?php

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\NumberPopulation;
use Hashbangcode\Wevolution\Evolution\Population\ColorPopulation;

class EvolutionTest extends \PHPUnit_Framework_TestCase {

  public function testEvolutionNumber()
  {
    $numberPopulation = new NumberPopulation();
    $evolution = new Evolution($numberPopulation);

    $population = $evolution->getCurrentPopulation();
    $this->assertEquals($evolution->getIndividualsPerGeneration(), $population->getLength());
  }

  public function testEvolutionColor()
  {
    $colorPopulation = new ColorPopulation();
    $evolution = new Evolution($colorPopulation);

    $population = $evolution->getCurrentPopulation();
    $this->assertEquals($evolution->getIndividualsPerGeneration(), $population->getLength());
  }

  public function testEvolutionSetPopulation()
  {
    $colorPopulation = new ColorPopulation();
    $evolution = new Evolution();

    $evolution->setPopulation($colorPopulation);

    $this->assertEquals(0, $evolution->getCurrentPopulation()->getLength());
  }

  public function testEvolutionRunGeneration()
  {
    $colorPopulation = new ColorPopulation();
    $colorPopulation->addIndividual();
    $evolution = new Evolution($colorPopulation);

    $evolution->runGeneration();
    $this->assertEquals(2, $evolution->getGeneration());
  }

  public function testEvolutionRunBlankGeneration()
  {
    $colorPopulation = new ColorPopulation();
    $evolution = new Evolution($colorPopulation);

    $this->assertFalse($evolution->runGeneration());
  }

  public function testEvolutionGetGeneration() {
    $colorPopulation = new ColorPopulation();
    $evolution = new Evolution($colorPopulation);

    $this->assertEquals(1, $evolution->getGeneration());
  }

  public function testEvolutionAllowedFitness() {
    $colorPopulation = new ColorPopulation();
    $evolution = new Evolution($colorPopulation);

    $evolution->setAllowedFitness(1);

    $this->assertEquals(1, $evolution->getAllowedFitness());
  }

  public function testEvolutionMaxGenerations() {
    $colorPopulation = new ColorPopulation();
    $evolution = new Evolution($colorPopulation);

    $evolution->setMaxGenerations(10);

    $this->assertEquals(10, $evolution->getMaxGenerations());
  }

  public function testEvolutionGlobalFitnessFactor() {
    $colorPopulation = new ColorPopulation();
    $evolution = new Evolution($colorPopulation);

    $evolution->setGlobalMutationFactor(2);

    $this->assertEquals(2, $evolution->getGlobalMutationFactor());
  }

  public function testEvolutionGlobalFitnessGoal() {
    $colorPopulation = new ColorPopulation();
    $evolution = new Evolution($colorPopulation);

    $evolution->setGlobalFitnessGoal('test');

    $this->assertEquals('test', $evolution->getGlobalFitnessGoal());
  }

  public function testEvolutionIndividualsPerGeneration() {
    $colorPopulation = new ColorPopulation();
    $evolution = new Evolution($colorPopulation);

    $evolution->setIndividualsPerGeneration(2);

    $this->assertEquals(2, $evolution->getIndividualsPerGeneration());
  }

  public function testEvolutionRunWithIndividualsLimit() {
    $colorPopulation = new ColorPopulation();
    $colorPopulation->addIndividual();
    $colorPopulation->addIndividual();

    $evolution = new Evolution($colorPopulation);

    $evolution->setIndividualsPerGeneration(4);

    $evolution->runGeneration();
    $this->assertEquals(4, $evolution->getCurrentPopulation()->getLength());
  }


  public function testEvolutionRender() {
    $colorPopulation = new ColorPopulation();
    $colorPopulation->addIndividual();
    $colorPopulation->addIndividual();
    $colorPopulation->setDefaultRenderType('cli');

    $evolution = new Evolution($colorPopulation);

    $evolution->runGeneration();

    $output = $evolution->renderGenerations(true, 'cli');

    $this->assertContains('1:', $output);
    $this->assertContains('2:', $output);
    $this->assertContains('MIN:', $output);
    $this->assertContains('MAX:', $output);
  }

  public function testEvolutionColorConstructorParameters() {
    $colorPopulation = new ColorPopulation();
    $colorPopulation->addIndividual();

    $evolution = new Evolution($colorPopulation, 10, 20);

    $evolution->runGeneration();

    $this->assertEquals(10, $evolution->getMaxGenerations());
    $this->assertEquals(20, $evolution->getIndividualsPerGeneration());

    $this->assertEquals($evolution->getIndividualsPerGeneration(), $evolution->getCurrentPopulation()->getLength());
  }

  public function testEvolutionColorAutoGeneratePopulation() {
    $colorPopulation = new ColorPopulation();
    $evolution = new Evolution($colorPopulation, 10, 20, true);

    $this->assertEquals(10, $evolution->getMaxGenerations());
    $this->assertEquals(20, $evolution->getIndividualsPerGeneration());

    $this->assertEquals($evolution->getIndividualsPerGeneration(), $evolution->getCurrentPopulation()->getLength());
  }
}
