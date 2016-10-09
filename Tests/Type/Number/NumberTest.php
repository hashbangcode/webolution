<?php

use Hashbangcode\Wevolution\Type\Number\Number;

/**
 * Test class for Color
 */
class NumberTest extends PHPUnit_Framework_TestCase
{

  public function testCreateNumber() {
    $object = new Number(1);
    $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Number\Number', $object);
  }

  /**
   * @dataProvider numbersProvider
   */
  public function testCreateNumbers($number) {
    $object = new Number($number);
    $this->assertEquals($number, $object->getNumber());
  }

  public function numbersProvider() {
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
  public function testCreateNonNumbers($notNumber) {
    $this->setExpectedException('Hashbangcode\Wevolution\Type\Number\Exception\InvalidNumberException', $notNumber . ' is not a number.');
    $object = new Number($notNumber);
  }

  public function nonNumbersProvider() {
    return array(
      array(''),
      array(FALSE),
      array('number'),
      array('1'),
      array('false'),
      array(NULL),
      array('123abc'),
      array(TRUE)
    );
  }

  /**
   * @dataProvider numbersToAddProvider
   */
  public function testNumberAdd($number1, $number2, $result) {
    $foo = self::getMethod('add');
    $obj = new Number($number1);
    $return = $foo->invokeArgs($obj, array($number1, $number2));
    $this->assertEquals($result, $return);
  }

  public function numbersToAddProvider() {
    return array(
      array(1, 1, 2),
      array(1, 2, 3),
    );
  }

  /**
   * @dataProvider numbersToSubtractProvider
   */
  public function testNumberSubtract($number1, $number2, $result) {
    $foo = self::getMethod('subtract');
    $obj = new Number($number1);
    $return = $foo->invokeArgs($obj, array($number1, $number2));
    $this->assertEquals($result, $return);
  }

  public function numbersToSubtractProvider() {
    return array(
      array(1, 1, 0),
      array(2, 1, 1),
    );
  }

  protected static function getMethod($name) {
    $class = new ReflectionClass('Hashbangcode\Wevolution\Type\Number\Number');
    $method = $class->getMethod($name);
    $method->setAccessible(true);
    return $method;
  }
}
