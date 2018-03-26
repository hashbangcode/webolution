<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Population\TextPopulation;
use Hashbangcode\Wevolution\Evolution\Individual\TextIndividual;

class TextPopulationTest extends \PHPUnit_Framework_TestCase
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
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\TextIndividual', $population->getRandomIndividual());
    }

    public function testAddItemsToTextPopulation()
    {
        $population = new TextPopulation();

        $population->addIndividual();
        $population->addIndividual();
        $population->addIndividual();

        $this->assertEquals(3, $population->getLength());
    }

    public function __testDefaultSort()
    {
      // @todo : refactor into decorator.
        $population = new TextPopulation();

        $population->addIndividual(TextIndividual::generateFromString('A'));
        $population->addIndividual(TextIndividual::generateFromString('B'));
        $population->addIndividual(TextIndividual::generateFromString('C'));
        $population->addIndividual(TextIndividual::generateFromString('D'));
        $population->addIndividual(TextIndividual::generateFromString('E'));

        $population->sort();

        $output = $population->render();
        $this->assertContains('A B C D E', $output);
    }

    public function testPopulationLength()
    {
        $population = new TextPopulation();

        $population->addIndividual(TextIndividual::generateRandomTextIndividual());
        $population->addIndividual(TextIndividual::generateRandomTextIndividual());
        $population->addIndividual(TextIndividual::generateRandomTextIndividual());

        $individuals = $population->getIndividuals();

        foreach ($individuals[0]->getObject() as $text) {
            $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Text\Text', $text);
        }
        $this->assertEquals(3, $population->getLength());
    }

    public function __testRenderPopulation()
    {
      // @todo : refactor into decorator.
        $population = new TextPopulation();

        $population->addIndividual(TextIndividual::generateFromString('wibble'));

        $output = $population->render();

        $this->assertContains('wibble', $output);
    }
}
