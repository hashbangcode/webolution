<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;

/**
 * Class Individual
 * @package Hashbangcode\Wevolution\Evolution\Individual
 */
abstract class Individual implements IndividualInterface {

  /**
   * @var
   */
  protected $object;

  /**
   * @var int
   */
  protected $mutationFactor;

  /**
   * Individual constructor.
   */
  public function __construct() {
    $this->mutationFactor = 0;
  }

  /**
   * @return int
   */
  public function getMutationFactor() {
    return $this->mutationFactor;
  }

  /**
   * @param int $mutationFactor
   */
  public function setMutationFactor($mutationFactor) {
    $this->mutationFactor = $mutationFactor;
  }

  /**
   * @return mixed
   */
  public function getObject() {
    return $this->object;
  }

  abstract public function getFitness();

  abstract public function render($renderType);

  /**
   *
   */
  public function __clone() {
    $object = $this->getObject();
    $this->object = clone $object;
  }
}