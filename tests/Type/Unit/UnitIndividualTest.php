<?php

namespace Hashbangcode\Webolution\Test\Type\Unit;

use Hashbangcode\Webolution\Type\Unit\UnitIndividual;
use PHPUnit\Framework\TestCase;

class UnitIndividualTest extends TestCase
{
    public function testCreateIndividual()
    {
        $object = UnitIndividual::generateRandomUnit();
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Unit\UnitIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Unit\Unit', $object->getObject());
    }

    public function testMutateNumberThroughIndividual()
    {
        $object = UnitIndividual::generateFromUnitArguments(1, 'px');

        $this->assertEquals('px', $object->getName());
        $this->assertEquals('px', $object->getSpecies());

        $object->mutate(-100, 1);
        $this->assertNotEquals(1, $object->getObject()->getNumber());
    }

    public function testMutateNumberThroughIndividualWithDifferentAmount()
    {
        $object = UnitIndividual::generateFromUnitArguments(1, 'px');
        $object->mutate(-100, 1);
        $this->assertNotEquals(1, $object->getObject()->getNumber());
    }

    public function testGetFitness()
    {
        $object = UnitIndividual::generateFromUnitArguments(1, 'px');
        $this->assertEquals(1, $object->getFitness());
        $object->getObject()->setNumber(8);
        $this->assertEquals(8, $object->getFitness());
    }

    public function testMutateZeroNumber()
    {
        $object = UnitIndividual::generateFromUnitArguments(1, 'px');
        $this->assertEquals(1, $object->getObject()->getNumber());
        $object->mutate(0, 0);
        $this->assertEquals(1, $object->getObject()->getNumber());
        $object->mutate(0, 0);
        $this->assertEquals(1, $object->getObject()->getNumber());
        $object->mutate(0, 0);
        $this->assertEquals(1, $object->getObject()->getNumber());
        $object->mutate(0, 0);
        $this->assertEquals(1, $object->getObject()->getNumber());
    }
}
