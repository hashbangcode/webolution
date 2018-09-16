<?php

namespace Hashbangcode\Webolution\Test\Evolution\Population;

use Hashbangcode\Webolution\Evolution\Population\NumberPopulation;
use Hashbangcode\Webolution\Evolution\Individual\NumberIndividual;

class NumberPopulationTest extends \PHPUnit_Framework_TestCase
{

    public function testEmptyNumberPopulation()
    {
        $numberPopulation = new NumberPopulation();
        $this->assertEquals(0, $numberPopulation->getLength());
    }

    public function testAddItemNumberPopulation()
    {
        $numberPopulation = new NumberPopulation();
        $numberPopulation->addIndividual();
        $this->assertEquals(1, $numberPopulation->getLength());
    }

    public function testGetRandomIndividual()
    {
        $numberPopulation = new NumberPopulation();
        $numberPopulation->addIndividual();
        $this->assertEquals(1, $numberPopulation->getLength());
        $this->assertInstanceOf('Hashbangcode\Webolution\Evolution\Individual\NumberIndividual', $numberPopulation->getRandomIndividual());
    }

    public function testAddItemsToNumberPopulation()
    {
        $numberPopulation = new NumberPopulation();

        $numberPopulation->addIndividual();
        $numberPopulation->addIndividual();
        $numberPopulation->addIndividual();

        $this->assertEquals(3, $numberPopulation->getLength());

        $population = $numberPopulation->getIndividuals();

        foreach ($population as $number) {
            $this->assertInstanceOf('Hashbangcode\Webolution\Type\Number\Number', $number->getObject());
        }
    }
}
