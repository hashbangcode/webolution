<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;


abstract class Individual implements IndividualInterface
{

  protected $object;

  protected $mutationFactor;

  public function __construct() {
    $this->mutationFactor = 0;
  }

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

  public function getObject() {
    return $this->object;
  }

  abstract public function getFitness();
  abstract public function render($renderType);

  public function __clone() {
    $object = $this->getObject();
    $this->object = clone $object;
  }
}