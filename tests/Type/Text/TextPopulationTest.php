<?php

namespace Hashbangcode\Webolution\Test\Type\Text;

use Hashbangcode\Webolution\Type\Text\TextPopulation;
use Hashbangcode\Webolution\Type\Text\TextIndividual;
use PHPUnit\Framework\TestCase;

class TextPopulationTest extends TestCase
{

    public function testPopulationCreationAndSetup()
    {
        $population = new TextPopulation();
        $this->assertEquals(0, $population->getIndividualCount());

        $population->addIndividual();
        $this->assertEquals(1, $population->getIndividualCount());

        $population->addIndividual();
        $this->assertEquals(2, $population->getIndividualCount());

        $population->addIndividual();
        $this->assertEquals(3, $population->getIndividualCount());

        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Text\TextIndividual', $population->getRandomIndividual());
    }

    public function testGetRandomIndividualWithEmptyPopulation()
    {
        $population = new TextPopulation();
        $this->assertEquals(0, $population->getIndividualCount());
        $this->assertFalse($population->getRandomIndividual());
    }

    public function testGetRandomIndividualsWithEmptyPopulation()
    {
        $population = new TextPopulation();
        $this->assertEquals(0, $population->getIndividualCount());
        $this->assertFalse($population->getRandomIndividuals(2));
    }

    public function testGetRandomIndividualsWithAmountGreaterThanTheCurrentPopulation()
    {
        $population = new TextPopulation();
        $population->addIndividual();
        $this->assertEquals(1, $population->getIndividualCount());
        $this->assertFalse($population->getRandomIndividuals(2));
    }

    public function testDefaultSort()
    {
        $population = new TextPopulation();

        $population->addIndividual(TextIndividual::generateFromString('A'));
        $population->addIndividual(TextIndividual::generateFromString('B'));
        $population->addIndividual(TextIndividual::generateFromString('C'));
        $population->addIndividual(TextIndividual::generateFromString('D'));
        $population->addIndividual(TextIndividual::generateFromString('E'));
        $population->addIndividual(TextIndividual::generateFromString('E'));

        $population->sort();

        $individuals = $population->getIndividuals();
        $this->assertEquals('A', $individuals[0]->getObject()->getText());
        $this->assertEquals('B', $individuals[1]->getObject()->getText());
        $this->assertEquals('C', $individuals[2]->getObject()->getText());
        $this->assertEquals('D', $individuals[3]->getObject()->getText());
        $this->assertEquals('E', $individuals[4]->getObject()->getText());
        $this->assertEquals('E', $individuals[5]->getObject()->getText());
    }

    public function testPopulationCrossoverOnEmptyPopulation()
    {
        $population = new TextPopulation();
        $population->crossover();
        $this->assertEquals(0, $population->getIndividualCount());

        $population->addIndividual(TextIndividual::generateFromString('A'));

        $population->crossover();
        $this->assertEquals(2, $population->getIndividualCount());
    }

    public function testPopulationCrossoverWithEqualStrings()
    {
        $population = new TextPopulation();

        $population->addIndividual(TextIndividual::generateFromString('ABCD'));
        $population->addIndividual(TextIndividual::generateFromString('EFGH'));

        $population->crossover();

        $this->assertEquals('EBGD', $population->getIndividuals()[2]->getObject()->getText());
        $this->assertEquals(3, $population->getIndividualCount());
    }

    public function testPopulationCrossoverWithUnequalStrings()
    {
        $population = new TextPopulation();

        $population->addIndividual(TextIndividual::generateFromString('ABCD'));
        $population->addIndividual(TextIndividual::generateFromString('EFGHIJK'));

        $population->crossover();

        $this->assertEquals('AFCHIJK', $population->getIndividuals()[2]->getObject()->getText());
        $this->assertEquals(3, $population->getIndividualCount());
    }
}
