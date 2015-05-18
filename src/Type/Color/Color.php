<?php

namespace Hashbangcode\Wevolution\Type\Color;

/**
 * Class Color
 */
class Color
{

  private $red = NULL;
  private $green = NULL;
  private $blue = NULL;

  private $hue = NULL;
  private $hue2 = NULL;

  private $croma = NULL;
  private $croma2 = NULL;

  private $value = NULL;
  private $lightness = NULL;
  private $intensity = NULL;

  /**
   * @var float The luma, based on Rec. 601 NTSC primaries.
   */
  private $luma = NULL;
  private $hsv_saturation = NULL;
  private $hsl_saturation = NULL;
  private $hsi_saturation = NULL;

  /**
   * @param $red integer The red level.
   * @param $green integer The green level.
   * @param $blue integer The blue level.
   */
  public function __construct($red, $green, $blue)
  {
    if (!is_numeric($red) || $red < 0 || $red > 255) {
        throw new Exception\InvalidRGBValueException('Incorrect value for Red in Color class');
    }

    if (!is_numeric($green) || $green < 0 || $green > 255) {
        throw new Exception\InvalidRGBValueException('Incorrect value for Green in Color class');
    }

    if (!is_numeric($blue) || $blue < 0 || $blue > 255) {
        throw new Exception\InvalidRGBValueException('Incorrect value for Blue in Color class');
    }

    $this->red = $red;
    $this->green = $green;
    $this->blue = $blue;
  }

  public static function generateFromHex($hex)
  {
    $hex = str_replace("#", "", $hex);

    if (strlen($hex) == 3) {
      $red = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
      $green = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
      $blue = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
    }
    else {
      $red = hexdec(substr($hex, 0, 2));
      $green = hexdec(substr($hex, 2, 2));
      $blue = hexdec(substr($hex, 4, 2));
    }

    return new Color($red, $green, $blue);
  }

  public static function generateFromHSV($hue, $saturation, $value)
  {
    $chroma = $value * $saturation;

    $hue_value = $hue / 60.0;

    $x = $chroma * (1 - abs(fmod($hue_value, 2) - 1));

    $match = $value - $chroma;

    if ($hue_value >= 0 && $hue_value < 1) {
      $red = $chroma;
      $green = $x;
      $blue = 0;
    }
    else if ($hue_value >= 1 && $hue_value < 2) {
      $red = $x;
      $green = $chroma;
      $blue = 0;
    }
    else if ($hue_value >= 2 && $hue_value < 3) {
      $red = 0;
      $green = $chroma;
      $blue = $x;
    }
    else if ($hue_value >= 3 && $hue_value < 4) {
      $red = 0;
      $green = $x;
      $blue = $chroma;
    }
    else if ($hue_value >= 4 && $hue_value < 5) {
      $red = $x;
      $green = 0;
      $blue = $chroma;
    }
    else {
      $red = $chroma;
      $green = 0;
      $blue = $x;
    }

    $red = round(($red + $match) * 255);
    $green = round(($green + $match) * 255);
    $blue = round(($blue + $match) * 255);

    $new_color = new Color($red, $green, $blue);
    $new_color->setHue($hue);
    $new_color->setHsvSaturation($saturation);
    $new_color->setValue($value);
    return $new_color;
  }

  public static function generateFromHSL($hue, $saturation, $lightness)
  {
    $chroma = (1 - abs(2 * $lightness - 1)) * $saturation;

    $match = $lightness - ($chroma / 2);

    $hue_value = $hue / 60;

    $x = $chroma * (1 - abs(fmod($hue_value, 2) - 1));

    if ($hue_value >= 0 && $hue_value < 1) {
      $red = $chroma;
      $green = $x;
      $blue = 0;
    }
    else if ($hue_value >= 1 && $hue_value < 2) {
      $red = $x;
      $green = $chroma;
      $blue = 0;
    }
    else if ($hue_value >= 2 && $hue_value < 3) {
      $red = 0;
      $green = $chroma;
      $blue = $x;
    }
    else if ($hue_value >= 3 && $hue_value < 4) {
      $red = 0;
      $green = $x;
      $blue = $chroma;
    }
    else if ($hue_value >= 4 && $hue_value < 5) {
      $red = $x;
      $green = 0;
      $blue = $chroma;
    }
    else {
      $red = $chroma;
      $green = 0;
      $blue = $x;
    }

    $red = round(($red + $match) * 255);
    $green = round(($green + $match) * 255);
    $blue = round(($blue + $match) * 255);

    $new_color = new Color($red, $green, $blue);
    $new_color->setHue($hue);
    $new_color->setHslSaturation($saturation);
    $new_color->setLightness($lightness);
    return $new_color;
  }

  public static function generateRandomColor()
  {
    //Return an RGB array
    $red = ceil(rand(0, 255));
    $green = ceil(rand(0, 255));
    $blue = ceil(rand(0, 255));

    return new Color($red, $blue, $green);
  }

  /**
   * Generate a hex value of the color based on the current RGB values.
   *
   * @return string The hex value.
   */
  public function getHex()
  {

    $rgb['red'] = str_pad(dechex($this->getRed()), 2, '0', STR_PAD_LEFT);
    $rgb['green'] = str_pad(dechex($this->getGreen()), 2, '0', STR_PAD_LEFT);
    $rgb['blue'] = str_pad(dechex($this->getBlue()), 2, '0', STR_PAD_LEFT);

    return strtoupper(implode($rgb));
  }

  /**
   * Get the RGB Value of a Color.
   *
   * @return string The RGB value.
   */
  public function getRGB() {
    return str_pad($this->getRed(), 3, STR_PAD_LEFT) .
     str_pad($this->getGreen(), 3, STR_PAD_LEFT) .
     str_pad($this->getBlue(), 3, STR_PAD_LEFT);
  }

  /**
   * @return null
   */
  public function getRed()
  {
    return $this->red;
  }

  /**
   * @param null $red
   */
  public function setRed($red)
  {
    $this->red = $red;
  }

  /**
   * @return null
   */
  public function getGreen()
  {
    return $this->green;
  }

  /**
   * @param null $green
   */
  public function setGreen($green)
  {
    $this->green = $green;
  }

  /**
   * @return null
   */
  public function getBlue()
  {
    return $this->blue;
  }

  /**
   * @param null $blue
   */
  public function setBlue($blue)
  {
    $this->blue = $blue;
  }

  /**
   * @return null
   */
  public function getCroma()
  {
    return $this->croma;
  }

  /**
   * @param null $croma
   */
  public function setCroma($croma)
  {
    $this->croma = $croma;
  }

  /**
   * @return null
   */
  public function getCroma2()
  {
    return $this->croma2;
  }

  /**
   * @param null $croma2
   */
  public function setCroma2($croma2)
  {
    $this->croma2 = $croma2;
  }

  /**
   * @return null
   */
  public function getHsiSaturation()
  {
    $this->calculateHsiSaturation();
    return $this->hsi_saturation;
  }

  /**
   * @param null $hsi_saturation
   */
  public function setHsiSaturation($hsi_saturation)
  {
    $this->hsi_saturation = $hsi_saturation;
  }

  /**
   *
   */
  protected function calculateHsiSaturation()
  {
    $red = $this->red / 255;
    $green = $this->green / 255;
    $blue = $this->blue / 255;

    $min = min($red, $green, $blue);
    $max = max($red, $green, $blue);

    if ($max - $min === 0) {
      $this->setHsiSaturation(0);
    }
    else {
      $this->setHsiSaturation(1 - $min / (($red + $green + $blue) / 3));
    }
  }

  /**
   * @return null
   */
  public function getHslSaturation()
  {
    $this->calculateHSL();
    return $this->hsl_saturation;
  }

  /**
   * @param null $hsl_saturation
   */
  public function setHslSaturation($hsl_saturation)
  {
    $this->hsl_saturation = $hsl_saturation;
  }

  /**
   *
   */
  protected function calculateHSL()
  {
    $hue = 0;

    $red = $this->red / 255;
    $green = $this->green / 255;
    $blue = $this->blue / 255;

    $chroma_min = min($red, $green, $blue);
    $chroma_max = max($red, $green, $blue);

    $lightness = ($chroma_max + $chroma_min) / 2;
    $delta = $chroma_max - $chroma_min;

    if ($delta == 0) {
      $hue = $saturation = 0; // achromatic
    }
    else {
      $saturation = $delta / (1 - abs(2 * $lightness - 1));

      switch ($chroma_max) {
        case $red:
          $hue = 60 * fmod((($green - $blue) / $delta), 6);
          if ($blue > $green) {
            //$hue += 360;
          }
          break;

        case $green:
          $hue = 60 * (($blue - $red) / $delta + 2);
          break;

        case $blue:
          $hue = 60 * (($red - $green) / $delta + 4);
          break;
      }
    }

    $this->hue = round($hue, 4);
    $this->hsl_saturation = round($saturation, 4);
    $this->lightness = round($lightness, 4);
  }

  /**
   * @return null
   */
  public function getHsvSaturation()
  {
    $this->calcualteHSV();
    return $this->hsv_saturation;
  }

  /**
   * @param null $hsv_saturation
   */
  public function setHsvSaturation($hsv_saturation)
  {
    $this->hsv_saturation = $hsv_saturation;
  }

  /**
   *
   */
  protected function calcualteHSV()
  {
    $red = $this->red / 255;
    $green = $this->green / 255;
    $blue = $this->blue / 255;

    $min = min($red, $green, $blue);
    $max = max($red, $green, $blue);

    switch ($max) {
      case 0:
        $this->hue = 0;
        $this->hsv_saturation = 0;
        $this->value = 0;
        break;
      case $min:
        $this->hue = 0;
        $this->hsv_saturation = 0;
        $this->value = round($max, 4);
        break;
      default:
        $delta = $max - $min;
        if ($red == $max) {
          $this->hue = 0 + ($green - $blue) / $delta;
        }
        elseif ($green == $max) {
          $this->hue = 2 + ($blue - $red) / $delta;
        }
        else {
          $this->hue = 4 + ($red - $green) / $delta;
        }
        $this->hue *= 60;
        if ($this->hue < 0) {
          $this->hue += 360;
        }
        $this->hsv_saturation = $delta / $max;
        $this->value = round($max, 4);
    }
  }

  /**
   * @return null
   */
  public function getHue()
  {
    $this->calcualteHSV();
    return $this->hue;
  }

  /**
   * @param null $hue
   */
  public function setHue($hue)
  {
    $this->hue = $hue;
  }

  /**
   * @return null
   */
  public function getHue2()
  {
    return $this->hue2;
  }

  /**
   * @param null $hue2
   */
  public function setHue2($hue2)
  {
    $this->hue2 = $hue2;
  }

  /**
   * @return null
   */
  public function getIntensity()
  {
    return $this->intensity;
  }

  /**
   * @param null $intensity
   */
  public function setIntensity($intensity)
  {
    $this->intensity = $intensity;
  }

  /**
   * @return null
   */
  public function getLightness()
  {
    $this->calculateHSL();
    return $this->lightness;
  }

  /**
   * @param null $lightness
   */
  public function setLightness($lightness)
  {
    $this->lightness = $lightness;
  }

  /**
   * @return float The current luma.
   */
  public function getLuma()
  {
    return $this->luma;
  }

  /**
   * @param float $luma The luma to set
   */
  public function setLuma($luma)
  {
    $this->luma = $luma;
  }

  /**
   * @return null
   */
  public function getValue()
  {
    $this->calcualteHSV();
    return $this->value;
  }

  /**
   * @param null $value
   */
  public function setValue($value)
  {
    $this->value = $value;
  }

  /**
   * Tweak a value in the RGB matrix for the color.
   *
   * @param int $amount The amount of alteration to make. Note that the RGB value of the color can't exceed 255 or be
   * less than 0. If this situation occurs the amounts are restricted.
   *
   * @return $this The current object.
   */
  public function mutateColor($amount = 1)
  {
    $this->resetColorGeometry();

    $rgb = $this->getColorArray();

    $rgb_key = $rgb[array_rand($rgb)];

    $operators = array('add', 'subtract');

    $value = call_user_func_array(array($this, $operators[array_rand($operators)]), array(
      $this->$rgb_key, $amount
    ));

    if (0 > $value) {
      $value = 0;
    }
    else if (255 < $value) {
      $value = 255;
    }

    $this->$rgb_key = $value;

    return $this;
  }

  /**
   * Utility function to reset all the calculated color geometry.
   *
   * This is used when alterations are made the the color that would mean the existing color geometry is incorrect.
   * This doesn't calculate the new values as this is done when they are called for e.g. the lightness is calculated
   * before being returned by the getLightness() method.
   */
  private function resetColorGeometry()
  {
    $this->hue = NULL;
    $this->hue2 = NULL;

    $this->croma = NULL;
    $this->croma2 = NULL;

    $this->value = NULL;
    $this->lightness = NULL;
    $this->intensity = NULL;

    $this->luma = NULL;

    $this->hsv_saturation = NULL;
    $this->hsl_saturation = NULL;
    $this->hsi_saturation = NULL;

  }

  /**
   * Get a standard array of red, green, and blue.
   *
   * @return array A standard RGB color array.
   */
  protected function getColorArray()
  {
    return array(
      'red',
      'green',
      'blue'
    );
  }

  /**
   * Randomise the color.
   *
   * @return $this The current Colour object
   */
  public function randomise()
  {
    $this->resetcolor();

    //Return an RGB array
    $this->setRed(ceil(rand(0, 255)));
    $this->setGreen(ceil(rand(0, 255)));
    $this->setBlue(ceil(rand(0, 255)));

    return $this->getColorArray();
  }

  /**
   * Reset the color values. Useful when randomising the color or calculating new values.
   */
  private function resetColor()
  {
    $this->red = NULL;
    $this->green = NULL;
    $this->blue = NULL;

    $this->resetColorGeometry();
  }

  /**
   * Helper function that adds two numbers together.
   *
   * @param $x integer The first number.
   * @param $y integer The second number.
   * @return integer The result of adding the numbers together.
   */
  protected function add($x, $y)
  {
    return $x + $y;
  }

  /**
   * @param $x
   * @param $y
   * @return mixed
   */
  protected function subtract($x, $y)
  {
    return $x - $y;
  }

}