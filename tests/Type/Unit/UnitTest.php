<?php

namespace Hashbangcode\Webolution\Test\Type\Unit;

use Hashbangcode\Webolution\Type\Unit\Unit;
use PHPUnit\Framework\TestCase;

class UnitTest extends TestCase
{
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

    public function testAddAndSubtractNumber()
    {
        $object = new Unit(1, 'px');
        $object->add(1);
        $this->assertEquals(2, $object->getNumber());
        $object->subtract(1);
        $this->assertEquals(1, $object->getNumber());
    }

    public function testInvalidUnit()
    {
        $this->expectException('Hashbangcode\Webolution\Type\Unit\Exception\InvalidUnitException');

        $object = new Unit(1, 'monkey');
    }

    public function testInvalidNumber()
    {
        $this->expectException('Hashbangcode\Webolution\Type\Unit\Exception\InvalidNumberException');

        $object = new Unit('monkey', 'px');
    }
}
