<?php

namespace Hashbangcode\Webolution\Test\Type\Number;

use Hashbangcode\Webolution\Type\Number\Number;
use PHPUnit\Framework\TestCase;

/**
 * Test class for Color
 */
class NumberTest extends TestCase
{
    /**
     * @dataProvider numbersProvider
     */
    public function testCreateNumbers($number)
    {
        $object = new Number($number);
        $this->assertEquals($number, $object->getNumber());
    }

    public function numbersProvider()
    {
        return array(
            array(1),
            array(2),
            array(3),
            array(100),
            array(123),
            array(112345778698707563),
            array(-234789),
            array(0),
            array(PHP_INT_MAX)
        );
    }

    /**
     * @dataProvider nonNumbersProvider
     */
    public function testCreateNonNumbers($notNumber)
    {
        $message = $notNumber . ' is not a number.';

        $this->expectException('Hashbangcode\Webolution\Type\Number\Exception\InvalidNumberException');
        $this->expectExceptionMessage($message);

        $object = new Number($notNumber);
    }

    public function nonNumbersProvider()
    {
        return array(
            array(''),
            array(false),
            array('number'),
            array('1'),
            array('false'),
            array(null),
            array('123abc'),
            array(true),
        );
    }

    /**
     * @dataProvider numbersToAddProvider
     */
    public function testNumberAdd($number1, $number2, $result)
    {
        $object = new Number($number1);
        $object->add($number2);
        $this->assertEquals($result, $object->getNumber());
    }

    public function numbersToAddProvider()
    {
        return array(
            array(1, 1, 2),
            array(1, 2, 3),
        );
    }

    /**
     * @dataProvider numbersToSubtractProvider
     */
    public function testNumberSubtract($number1, $number2, $result)
    {
        $object = new Number($number1);
        $object->subtract($number2);
        $this->assertEquals($result, $object->getNumber());
    }

    public function numbersToSubtractProvider()
    {
        return array(
            array(1, 1, 0),
            array(2, 1, 1),
        );
    }

    protected static function getMethod($name)
    {
        $class = new \ReflectionClass('Hashbangcode\Webolution\Type\Number\Number');
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}
