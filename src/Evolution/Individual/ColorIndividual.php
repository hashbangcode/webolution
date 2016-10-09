<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;

use Hashbangcode\Wevolution\Type\Color\Color;

/**
 * Class ColorIndividual
 */
class ColorIndividual extends Individual
{

  /**
   * ColorIndividual constructor.
   * @param $red
   * @param $green
   * @param $blue
   */
  public function __construct($red, $green, $blue)
  {
    $this->object = new Color($red, $green, $blue);
  }

  /**
   *
   */
  public function mutateProperties()
  {
    $this->object->mutateColor($this->getMutationFactor());
  }

  /**
   * @return float
   */
  public function getFitness() {
    $color = $this->getObject();
    $lightness = $color->getLightness();
    return round(abs(($lightness * 10) - 10));
  }

  /**
   * @param $renderType
   * @return string
   */
  public function render($renderType = 'cli')
  {
    switch ($renderType) {
      case 'html':
        return '<span style="background-color:#' . $this->object->render() . '"> </span>';
      case 'cli':
      default:
        return $this->object->render() . PHP_EOL;
    }
  }

  /**
   * @return \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual
   */
  public static function generateRandomColor()
  {
    // Return an RGB array.
    $red = ceil(mt_rand(0, 255));
    $green = ceil(mt_rand(0, 255));
    $blue = ceil(mt_rand(0, 255));

    return new ColorIndividual($red, $blue, $green);
  }
}