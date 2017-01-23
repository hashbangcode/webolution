<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;

use Hashbangcode\Wevolution\Type\Number\Number;

/**
 * Class NumberIndividual
 * @package Hashbangcode\Wevolution\Evolution\Individual
 */
class NumberIndividual extends Individual
{

  /**
   * NumberIndividual constructor.
   * @param $number
   */
  public function __construct($number)
  {
    $this->object = new Number($number);
  }

  /**
   * @return \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual
   */
  public static function generateRandomNumber()
  {
    $number = mt_rand(1, 10);
    return new NumberIndividual($number);
  }

  /**
   *
   */
  public function mutateProperties()
  {
    $this->mutateNumber($this->getMutationFactor());
    return $this;
  }

  /**
   * @param int $amount
   * @throws \Hashbangcode\Wevolution\Type\Number\Exception\InvalidNumberException
   */
  public function mutateNumber($amount = 1)
  {
    $operators = array('add', 'subtract');

    $number = $this->getObject()->getNumber();

    switch ($operators[array_rand($operators)]) {
      case 'add':
        $value = $number + $amount;
        break;
      case 'subtract':
        $value = $number - $amount;
        break;
    }

    $this->getObject()->setNumber($value);
  }

  /**
   * @return mixed
   */
  public function getFitness()
  {
    return $this->getObject()->getNumber();
  }

  /**
   * @param $renderType
   * @return mixed
   */
  public function render($renderType = 'cli')
  {
    $output = '';
    switch ($renderType) {
      case 'html':
        $output = $this->object->render() . ' ';
      case 'cli':
      default:
        $output = $this->object->render() . ' ';
    }
    return $output;
  }
}