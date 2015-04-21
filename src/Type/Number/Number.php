<?php

namespace Hashbangcode\Wevolution\Type\Number;

use Hashbangcode\Wevolution\Type\Number\Exception\InvalidNumberException;

class Number
{
  protected $number;

  /**
   * @return mixed
   */
  public function getNumber()
  {
    return $this->number;
  }

  /**
   * @param mixed $number
   */
  public function setNumber($number)
  {
    if (!is_int($number)) {
      throw new InvalidNumberException($number . ' is not a number.');
    } else {
      $this->number = $number;
    }
  }

  public function __construct($number) {
    $this->setNumber($number);
  }

  public function mutateNumber($amount = 1) {
    $operators = array('add', 'subtract');

    $value = call_user_func_array(array($this, $operators[array_rand($operators)]), array(
      $this->getNumber(), $amount
    ));

    $this->setNumber($value);
  }

  /**
   * Helper function that adds two numbers together.
   *
   * @param $x integer The first number.
   * @param $y integer The second number.
   * @return integer The result of adding the numbers together.
   */
  protected function add($x, $y)
  {
    return $x + $y;
  }

  /**
   * @param $x
   * @param $y
   * @return mixed
   */
  protected function subtract($x, $y)
  {
    return $x - $y;
  }
}