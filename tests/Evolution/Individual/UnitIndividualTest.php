<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual;

use Hashbangcode\Wevolution\Evolution\Individual\UnitIndividual;

/**
 * Test class for ColorIndividual
 */
class UnitIndividualTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateIndividual()
    {
        $object = UnitIndividual::generateRandomUnit(1, 'px');
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\UnitIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Unit\Unit', $object->getObject());
    }

    public function testMutateNumberThroughIndividual()
    {
        $object = UnitIndividual::generateFromUnitArguments(1, 'px');
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

    public function testCliRender()
    {
        $object = UnitIndividual::generateFromUnitArguments(1, 'px');
        $renderType = 'cli';
        $this->assertEquals('1px', $object->render($renderType));
    }

    public function testHtmlRender()
    {
        $object = UnitIndividual::generateFromUnitArguments(1, 'px');
        $renderType = 'html';
        $this->assertEquals('1px', $object->render($renderType));
    }

    public function testDefaultRender()
    {
        $object = UnitIndividual::generateFromUnitArguments(1, 'px');
        $this->assertEquals('1px', $object->render());
    }

    public function testMutateUnit()
    {
        $object = UnitIndividual::generateFromUnitArguments(1, 'px');
        $object->mutate();
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
