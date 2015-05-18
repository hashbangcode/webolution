<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;
use Hashbangcode\Wevolution\Type\Number\Number;

/**
 * Class ColorIndividual
 */
class NumberIndividual extends Individual
{
  protected $mutationFactor = 1;

  /**
   * @return int
   */
  public function getMutationFactor()
  {
    return $this->mutationFactor;
  }

  /**
   * @param int $mutationFactor
   */
  public function setMutationFactor($mutationFactor)
  {
    $this->mutationFactor = $mutationFactor;
  }

  public function __construct($number) {
    $this->object = new Number($number);
  }

  public function mutateProperties() {
    $this->getObject()->mutateNumber($this->getMutationFactor());
  }

  public function getFitness() {
    return $this->getObject()->getNumber();
  }

  public function toString() {
    return $this->getObject()->getNumber();
  }

  public static function generateRandomNumber() {
    $number = rand(1, 10);
    return new NumberIndividual($number);
  }
}