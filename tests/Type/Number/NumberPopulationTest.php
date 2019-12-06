<?php

namespace Hashbangcode\Webolution\Test\Type\Number;

use Hashbangcode\Webolution\Type\Number\NumberPopulation;
use Hashbangcode\Webolution\Type\Number\NumberIndividual;
use PHPUnit\Framework\TestCase;

class NumberPopulationTest extends TestCase
{

    public function testEmptyNumberPopulation()
    {
        $numberPopulation = new NumberPopulation();
        $this->assertEquals(0, $numberPopulation->getIndividualCount());
    }

    public function testAddItemNumberPopulation()
    {
        $numberPopulation = new NumberPopulation();
        $numberPopulation->addIndividual();
        $this->assertEquals(1, $numberPopulation->getIndividualCount());
    }

    public function testGetRandomIndividual()
    {
        $numberPopulation = new NumberPopulation();
        $numberPopulation->addIndividual();
        $this->assertEquals(1, $numberPopulation->getIndividualCount());
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Number\NumberIndividual', $numberPopulation->getRandomIndividual());
    }

    public function testAddItemsToNumberPopulation()
    {
        $numberPopulation = new NumberPopulation();

        $numberPopulation->addIndividual();
        $numberPopulation->addIndividual();
        $numberPopulation->addIndividual();

        $this->assertEquals(3, $numberPopulation->getIndividualCount());

        $population = $numberPopulation->getIndividuals();

        foreach ($population as $number) {
            $this->assertInstanceOf('Hashbangcode\Webolution\Type\Number\Number', $number->getObject());
        }
    }
}
