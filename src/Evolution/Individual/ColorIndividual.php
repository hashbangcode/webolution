<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;
use Hashbangcode\Wevolution\Type\Color\Color;

/**
 * Class ColorIndividual
 */
class ColorIndividual extends Individual
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

  public function __construct($red, $green, $blue) {
    $this->object = new Color($red, $green, $blue);
  }

  public function mutateProperties() {
    $this->object->mutateColor($this->getMutationFactor());
  }

  public function getFitness() {

  }
}