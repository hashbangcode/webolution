<?php

namespace Hashbangcode\Webolution\Test\Type\Text;

use Hashbangcode\Webolution\Type\Text\TextPopulation;
use Hashbangcode\Webolution\Type\Text\TextIndividual;
use PHPUnit\Framework\TestCase;

class TextPopulationTest extends TestCase
{

    public function testEmptyPopulation()
    {
        $population = new TextPopulation();
        $this->assertEquals(0, $population->getLength());
    }

    public function testAddItemPopulation()
    {
        $population = new TextPopulation();
        $population->addIndividual();
        $this->assertEquals(1, $population->getLength());
    }

    public function testGetRandomIndividual()
    {
        $population = new TextPopulation();
        $population->addIndividual();
        $this->assertEquals(1, $population->getLength());
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Text\TextIndividual', $population->getRandomIndividual());
    }

    public function testGetRandomIndividualWithEmptyPopulation()
    {
        $population = new TextPopulation();
        $this->assertEquals(0, $population->getLength());
        $this->assertFalse($population->getRandomIndividual());
    }

    public function testGetRandomIndividualsWithEmptyPopulation()
    {
        $population = new TextPopulation();
        $this->assertEquals(0, $population->getLength());
        $this->assertFalse($population->getRandomIndividuals(2));
    }

    public function testGetRandomIndividualsWithAmountGreaterThanTheCurrentPopulation()
    {
        $population = new TextPopulation();
        $population->addIndividual();
        $this->assertEquals(1, $population->getLength());
        $this->assertFalse($population->getRandomIndividuals(2));
    }

    public function testAddItemsToTextPopulation()
    {
        $population = new TextPopulation();

        $population->addIndividual();
        $population->addIndividual();
        $population->addIndividual();

        $this->assertEquals(3, $population->getLength());
    }

    public function testDefaultSort()
    {
        $population = new TextPopulation();

        $population->addIndividual(TextIndividual::generateFromString('A'));
        $population->addIndividual(TextIndividual::generateFromString('B'));
        $population->addIndividual(TextIndividual::generateFromString('C'));
        $population->addIndividual(TextIndividual::generateFromString('D'));
        $population->addIndividual(TextIndividual::generateFromString('E'));

        $population->sort();

        $individuals = $population->getIndividuals();
        $this->assertEquals('A', $individuals[0]->getObject()->getText());
        $this->assertEquals('B', $individuals[1]->getObject()->getText());
        $this->assertEquals('C', $individuals[2]->getObject()->getText());
        $this->assertEquals('D', $individuals[3]->getObject()->getText());
        $this->assertEquals('E', $individuals[4]->getObject()->getText());
    }

    public function testPopulationLength()
    {
        $population = new TextPopulation();

        $population->addIndividual(TextIndividual::generateRandomTextIndividual());
        $population->addIndividual(TextIndividual::generateRandomTextIndividual());
        $population->addIndividual(TextIndividual::generateRandomTextIndividual());

        $individuals = $population->getIndividuals();

        foreach ($individuals[0]->getObject() as $text) {
            $this->assertInstanceOf('Hashbangcode\Webolution\Type\Text\Text', $text);
        }
        $this->assertEquals(3, $population->getLength());
    }
}
