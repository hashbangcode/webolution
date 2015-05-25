<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;
use Hashbangcode\Wevolution\Type\Number\Number;

/**
 * Class ColorIndividual
 */
class NumberIndividual extends Individual
{

  public function __construct($number) {
    $this->object = new Number($number);
  }

  public function mutateProperties() {
    $this->getObject()->mutateNumber($this->getMutationFactor());
  }

  public function getFitness() {
    return $this->getObject()->getNumber();
  }

  public function render() {
    return $this->getObject()->render();
  }

  public static function generateRandomNumber() {
    $number = rand(1, 10);
    return new NumberIndividual($number);
  }
}