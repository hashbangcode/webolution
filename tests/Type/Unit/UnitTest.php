<?php

namespace Hashbangcode\Wevolution\Test\Type\Unit;

use Hashbangcode\Wevolution\Type\Unit\Unit;

/**
 * Test class for Color
 */
class UnitTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateUnit()
    {
        $object = new Unit(1, 'px');
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Unit\Unit', $object);
    }

    public function testSetAndGetUnit()
    {
        $object = new Unit(1, 'px');
        $this->assertEquals('px', $object->getUnit());
        $object->setUnit('em');
        $this->assertEquals('em', $object->getUnit());
    }

    public function testSetAndGetNumber()
    {
        $object = new Unit(1, 'px');
        $this->assertEquals(1, $object->getNumber());
        $object->setNumber(2);
        $this->assertEquals(2, $object->getNumber());
    }

    public function testInvalidUnit()
    {
        $this->setExpectedException('Hashbangcode\Wevolution\Type\Unit\Exception\InvalidUnitException');
        $object = new Unit(1, 'monkey');
    }

    public function testInvalidNumber()
    {
        $this->setExpectedException('Hashbangcode\Wevolution\Type\Unit\Exception\InvalidNumberException');
        $object = new Unit('monkey', 'px');
    }
}
