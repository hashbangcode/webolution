<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;


abstract class Individual implements IndividualInterface
{

  protected $object;

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

  public function getObject() {
    return $this->object;
  }

  abstract public function getFitness();
  abstract public function render();
}