<?php

namespace Hashbangcode\Wevolution\Test\Type\Unit;

use Hashbangcode\Wevolution\Type\Unit\Unit;

/**
 * Test class for Color
 */
class UnitTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateText()
    {
        $object = new Unit(1, 'px');
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Unit\Unit', $object);
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
