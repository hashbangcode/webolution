<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;

use Hashbangcode\Wevolution\Type\Number\Number;

/**
 * Class NumberIndividual
 * @package Hashbangcode\Wevolution\Evolution\Individual
 */
class NumberIndividual extends Individual {

  /**
   * NumberIndividual constructor.
   * @param $number
   */
  public function __construct($number) {
    $this->object = new Number($number);
  }

  /**
   * @return \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual
   */
  public static function generateRandomNumber() {
    $number = rand(1, 10);
    return new NumberIndividual($number);
  }

  /**
   *
   */
  public function mutateProperties() {
    $this->getObject()->mutateNumber($this->getMutationFactor());
  }

  /**
   * @return mixed
   */
  public function getFitness() {
    return $this->getObject()->getNumber();
  }

  /**
   * @param $renderType
   * @return mixed
   */
  public function render($renderType = 'cli') {
    switch ($renderType) {
      case 'html':
        return $this->object->render() . ' ';
      case 'cli':
      default:
        return $this->object->render() . ' ';
    }
  }
}