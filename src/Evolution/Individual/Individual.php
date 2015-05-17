<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;


abstract class Individual implements IndividualInterface
{

  protected $object;

  public function __construct() {

  }

  public function getObject() {
    return $this->object;
  }

  abstract public function getFitness();
  abstract public function toString();
}