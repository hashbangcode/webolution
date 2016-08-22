<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;

use Hashbangcode\Wevolution\Type\Color\Color;

/**
 * Class ColorIndividual
 */
class ColorIndividual extends Individual
{

  public function __construct($red, $green, $blue)
  {
    $this->object = new Color($red, $green, $blue);
  }

  public function mutateProperties()
  {
    $this->object->mutateColor($this->getMutationFactor());
  }

  public function getFitness()
  {
    $color = $this->getObject();
    $lightness = $color->getLightness();
    return round($lightness * 10);
  }

  public function render($renderType)
  {
    switch ($renderType) {
      case 'html':
        return '<div style="background-color:#' . $this->object->render() . '"> </div>';
      case 'cli':
      default:
        return $this->object->render();
    }
  }

  public static function generateRandomColor()
  {
    // Return an RGB array.
    $red = ceil(rand(0, 255));
    $green = ceil(rand(0, 255));
    $blue = ceil(rand(0, 255));

    return new ColorIndividual($red, $blue, $green);
  }
}