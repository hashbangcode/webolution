<?php

namespace Hashbangcode\Webolution\Test\Evolution\Individual;

use Hashbangcode\Webolution\Evolution\Individual\NumberIndividual;

/**
 * Test class for ColorIndividual
 */
class NumberIndividualTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateIndividual()
    {
        $object = NumberIndividual::generateFromNumber(1);
        $this->assertInstanceOf('Hashbangcode\Webolution\Evolution\Individual\NumberIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Number\Number', $object->getObject());
    }

    public function testMutateNumberThroughIndividual()
    {
        $object = NumberIndividual::generateFromNumber(1);
        $object->mutate(-100, 1);
        $this->assertNotEquals(1, $object->getObject()->getNumber());
    }

    public function testMutateNumberThroughIndividualWithDifferentAmount()
    {
        $object = NumberIndividual::generateFromNumber(1);
        $object->mutate(-100, 1);
        $this->assertNotEquals(1, $object->getObject()->getNumber());
    }

    public function testGetFitness()
    {
        $object = NumberIndividual::generateFromNumber(1);
        $this->assertEquals(1, $object->getFitness());
        $object->getObject()->setNumber(8);
        $this->assertEquals(8, $object->getFitness());
    }

    public function testMutateNumber()
    {
        $object = NumberIndividual::generateFromNumber(1);
        $this->assertEquals(1, $object->getObject()->getNumber());
        $object->mutate(-1);
        $this->assertNotEquals(1, $object->getObject()->getNumber());
    }

    public function testMutateZeroNumber()
    {
        $object = NumberIndividual::generateFromNumber(1);
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
