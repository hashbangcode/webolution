<?php

namespace Hashbangcode\Webolution\Test\Population;

use Hashbangcode\Webolution\Type\Number\NumberPopulation;
use Hashbangcode\Webolution\Type\Number\NumberIndividual;

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
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Number\NumberIndividual', $numberPopulation->getRandomIndividual());
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
