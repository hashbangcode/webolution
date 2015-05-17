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

  public function toString() {

  }

  public static function generateRandomColor() {
    //Return an RGB array
    $red = ceil(rand(0, 255));
    $green = ceil(rand(0, 255));
    $blue = ceil(rand(0, 255));

    return new ColorIndividual($red, $blue, $green);
  }
}