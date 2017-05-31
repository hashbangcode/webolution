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

    /**
     * @dataProvider unitRender
     */
    public function testRender($number, $unit, $render)
    {
        $object = new Unit($number, $unit);
        $this->assertEquals($render, $object->render());
    }

    public function unitRender()
    {
        return [
            [1, 'px', '1px'],
            [50, 'px', '50px'],
            [-1, 'px', '-1px'],
            [1, 'em', '1em'],
            [100, 'em', '100em'],
            [1, '%', '1%'],
            [123, '%', '123%'],
            [1, 'auto', 'auto'],
        ];
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
