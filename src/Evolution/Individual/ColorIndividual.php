<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;

use Hashbangcode\Wevolution\Type\Color\Color;

/**
 * Class ColorIndividual
 */
class ColorIndividual extends Individual
{

  /**
   * @var \Hashbangcode\Wevolution\Type\Color\Color
   */
  protected $object;

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
    $this->mutateColor($this->getMutationFactor());
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

  /**
   * Tweak a value in the RGB matrix for the color.
   *
   * @param int $amount The amount of alteration to make. Note that the RGB value of the color can't exceed 255 or be
   * less than 0. If this situation occurs the amounts are restricted.
   *
   * @return $this The current object.
   */
  public function mutateColor($mutationFactor) {
    if (rand(0,1) < $mutationFactor) {
      $amount = 5;

      $rgb = $this->getObject()->getColorArray();

      $rgb_key = ucfirst($rgb[array_rand($rgb)]);

      $operators = array('add', 'subtract');

      switch ($operators[array_rand($operators)]) {
        case 'add':
          $value = $this->getObject()->{'get' . $rgb_key}() + $amount;
          break;
        case 'subtract':
          $value = $this->getObject()->{'get' . $rgb_key}() - $amount;
          break;
      }

      if (0 > $value) {
        $value = 0;
      }
      else {
        if (255 < $value) {
          $value = 255;
        }
      }

      $this->getObject()->{'set' . $rgb_key}($value);
    }

    return $this;
  }
}