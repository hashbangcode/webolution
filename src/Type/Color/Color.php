<?php

namespace Hashbangcode\Wevolution\Type\Color;

use Hashbangcode\Wevolution\Type\TypeInterface;

/**
 * Class Color.
 *
 * @package Hashbangcode\Wevolution\Type\Color
 */
class Color implements TypeInterface
{

    /**
     * The amount of red.
     *
     * @var int|null
     */
    private $red = null;

    /**
     * The amount of green.
     *
     * @var int|null
     */
    private $green = null;

    /**
     * The amount of blue.
     *
     * @var int|null
     */
    private $blue = null;

    /**
     * The hue of the color.
     *
     * @var null
     */
    private $hue = null;

    /**
     * The hue2 value of the color.
     *
     * @var null
     */
    private $hue2 = null;

    /**
     * The croma value of the color.
     *
     * @var null
     */
    private $croma = null;

    /**
     * The croma2 value of the color.
     *
     * @var null
     */
    private $croma2 = null;

    /**
     * @var null
     *   The value of the color.
     */
    private $value = null;

    /**
     * The lightness of the color.
     *
     * @var null
     */
    private $lightness = null;

    /**
     * The intensity of the color.
     *
     * @var null
     */
    private $intensity = null;

    /**
     * The luma, based on Rec. 601 NTSC primaries.
     *
     * @var float
     */
    private $luma = null;

    /**
     * The HSV saturation value of the color.
     *
     * @var null
     */
    private $hsv_saturation = null;

    /**
     * The HSL saturation value of the color.
     *
     * @var null
     */
    private $hsl_saturation = null;

    /**
     * The HSI saturation value of the color.
     *
     * @var null
     */
    private $hsi_saturation = null;

    /**
     * Color contrsuctor.
     *
     * @param int $red
     *   The red level, between 0 and 255.
     * @param int $green
     *   The green level, between 0 and 255.
     * @param int $blue
     *   The blue level, between 0 and 255.
     *
     * @throws Exception\InvalidRGBValueException
     *   If invalid numbers are given for color values.
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

    /**
     * Generate a Color object from a hex value.
     *
     * @param string $hex
     *   The vex value. May, or may not contain a # in front.
     *
     * @return \Hashbangcode\Wevolution\Type\Color\Color
     *   The new colour object.
     */
    public static function generateFromHex($hex)
    {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $red = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $green = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $blue = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $red = hexdec(substr($hex, 0, 2));
            $green = hexdec(substr($hex, 2, 2));
            $blue = hexdec(substr($hex, 4, 2));
        }

        return new Color($red, $green, $blue);
    }

    /**
     * Generate a Color from HSV values.
     *
     * @param $hue
     * @param $saturation
     * @param $value
     * @return \Hashbangcode\Wevolution\Type\Color\Color
     */
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
        } else {
            if ($hue_value >= 1 && $hue_value < 2) {
                $red = $x;
                $green = $chroma;
                $blue = 0;
            } else {
                if ($hue_value >= 2 && $hue_value < 3) {
                    $red = 0;
                    $green = $chroma;
                    $blue = $x;
                } else {
                    if ($hue_value >= 3 && $hue_value < 4) {
                        $red = 0;
                        $green = $x;
                        $blue = $chroma;
                    } else {
                        if ($hue_value >= 4 && $hue_value < 5) {
                            $red = $x;
                            $green = 0;
                            $blue = $chroma;
                        } else {
                            $red = $chroma;
                            $green = 0;
                            $blue = $x;
                        }
                    }
                }
            }
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

    /**
     * Generate the color from HSL values.
     *
     * @param int $hue
     * @param $saturation
     * @param $lightness
     * @return Color
     */
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
        } else {
            if ($hue_value >= 1 && $hue_value < 2) {
                $red = $x;
                $green = $chroma;
                $blue = 0;
            } else {
                if ($hue_value >= 2 && $hue_value < 3) {
                    $red = 0;
                    $green = $chroma;
                    $blue = $x;
                } else {
                    if ($hue_value >= 3 && $hue_value < 4) {
                        $red = 0;
                        $green = $x;
                        $blue = $chroma;
                    } else {
                        if ($hue_value >= 4 && $hue_value < 5) {
                            $red = $x;
                            $green = 0;
                            $blue = $chroma;
                        } else {
                            $red = $chroma;
                            $green = 0;
                            $blue = $x;
                        }
                    }
                }
            }
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

    /**
     * Generate red, green and blue values and then create a Color object.
     *
     * @return Color
     */
    public static function generateRandomColor()
    {
        $red = ceil(mt_rand(0, 255));
        $green = ceil(mt_rand(0, 255));
        $blue = ceil(mt_rand(0, 255));

        return new Color($red, $blue, $green);
    }

    /**
     * Get the RGB Value of a Color.
     *
     * @return string The RGB value.
     */
    public function getRGB()
    {
        return str_pad($this->getRed(), 3, STR_PAD_LEFT) .
            str_pad($this->getGreen(), 3, STR_PAD_LEFT) .
            str_pad($this->getBlue(), 3, STR_PAD_LEFT);
    }

    /**
     * Get the red value of the color.
     *
     * @return int|null
     *   The red value.
     */
    public function getRed()
    {
        return $this->red;
    }

    /**
     * Set the red value of the color.
     *
     * @param int $red
     *   The red value.
     */
    public function setRed($red)
    {
        $this->red = $red;
    }

    /**
     * Get the green value of the color.
     *
     * @return int|null
     *   The green value.
     */
    public function getGreen()
    {
        return $this->green;
    }

    /**
     * Set the green value of the color.
     *
     * @param int $green
     *   The green value.
     */
    public function setGreen($green)
    {
        $this->green = $green;
    }

    /**
     * Get the blue value of the color.
     *
     * @return int|null
     *   The blue value.
     */
    public function getBlue()
    {
        return $this->blue;
    }

    /**
     * Set the blue value of the color.
     *
     * @param int $blue
     *   The blue value.
     */
    public function setBlue($blue)
    {
        $this->blue = $blue;
    }

    /**
     * Get the croma value of the color.
     *
     * @return null
     *   The croma value.
     */
    public function getCroma()
    {
        return $this->croma;
    }

    /**
     * Set the croma.
     *
     * @param null $croma
     *   The croma.
     */
    public function setCroma($croma)
    {
        $this->croma = $croma;
    }

    /**
     * Get croma2.
     *
     * @return null
     *   The croma2.
     */
    public function getCroma2()
    {
        return $this->croma2;
    }

    /**
     * Set croma2.
     *
     * @param null $croma2
     *   The croma2.
     */
    public function setCroma2($croma2)
    {
        $this->croma2 = $croma2;
    }

    /**
     * Get the HSI saturation.
     *
     * @return null
     *   The HSI saturation.
     */
    public function getHsiSaturation()
    {
        $this->calculateHsiSaturation();
        return $this->hsi_saturation;
    }

    /**
     * Set the HSI saturation.
     *
     * @param null $hsi_saturation
     *   The hsi saturation.
     */
    public function setHsiSaturation($hsi_saturation)
    {
        $this->hsi_saturation = $hsi_saturation;
    }

    /**
     * Calculate the HSI saturation values for the color.
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
        } else {
            $this->setHsiSaturation(1 - $min / (($red + $green + $blue) / 3));
        }
    }

    /**
     * Get the HSL saturation value for the color. This method calculates the value if it isn't set.
     *
     * @return null|int
     *   The HSL saturation value.
     */
    public function getHslSaturation()
    {
        $this->calculateHSL();
        return $this->hsl_saturation;
    }

    /**
     * Set the HSL saturation.
     *
     * @param null $hsl_saturation
     *   The HSL saturation.
     */
    public function setHslSaturation($hsl_saturation)
    {
        $this->hsl_saturation = $hsl_saturation;
    }

    /**
     * Calculate the HSL saturation values for the color.
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
        } else {
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
     * Get the HSV saturation.
     *
     * @return null
     *   The HSV saturation.
     */
    public function getHsvSaturation()
    {
        $this->calcualteHSV();
        return $this->hsv_saturation;
    }

    /**
     * Set the HSV saturation.
     *
     * @param null $hsv_saturation
     *   The HSV saturation.
     */
    public function setHsvSaturation($hsv_saturation)
    {
        $this->hsv_saturation = $hsv_saturation;
    }

    /**
     * Calculate the HSV color wheel values for the color.
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
                } elseif ($green == $max) {
                    $this->hue = 2 + ($blue - $red) / $delta;
                } else {
                    $this->hue = 4 + ($red - $green) / $delta;
                }
                $this->hue *= 60;
                if ($this->hue < 0) {
                    $this->hue += 360;
                }
                $this->hsv_saturation = $delta / $max;
                $this->value = round($max, 4);
        }

        // Ensure that Luma is also calculated.
        $this->calculateLuma();
    }

    /**
     * Calculate the luma value for the color.
     */
    public function calculateLuma()
    {
        // Luma is calculated by 0.2126R + 0.7152G + 0.0722B
        $luma = (0.2126 * $this->red) + (0.7152 * $this->green) + (.0722 * $this->blue);
        $this->luma = $luma;
    }

    /**
     * Get the hue.
     *
     * @return null
     *   The hue.
     */
    public function getHue()
    {
        $this->calcualteHSV();
        return $this->hue;
    }

    /**
     * Set the hue.
     *
     * @param null $hue
     *   The hue.
     */
    public function setHue($hue)
    {
        $this->hue = $hue;
    }

    /**
     * Get the hue2.
     *
     * @return null
     *   The hue2.
     */
    public function getHue2()
    {
        return $this->hue2;
    }

    /**
     * Set hue2.
     *
     * @param null $hue2
     *   The hue2.
     */
    public function setHue2($hue2)
    {
        $this->hue2 = $hue2;
    }

    /**
     * Get the intensity.
     *
     * @return null
     *   The intensity.
     */
    public function getIntensity()
    {
        return $this->intensity;
    }

    /**
     * Set the intensity.
     *
     * @param null $intensity
     *   The intensity.
     */
    public function setIntensity($intensity)
    {
        $this->intensity = $intensity;
    }

    /**
     * Get the lightness.
     *
     * @return float
     *   The lightness.
     */
    public function getLightness()
    {
        $this->calculateHSL();
        return $this->lightness;
    }

    /**
     * Set the lightness.
     *
     * @param null $lightness
     */
    public function setLightness($lightness)
    {
        $this->lightness = $lightness;
    }

    /**
     * Get he luma.
     *
     * @return float The current luma.
     */
    public function getLuma()
    {
        $this->calcualteHSV();
        return $this->luma;
    }

    /**
     * Set the luma.
     *
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
     *   The value of the color.
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Randomise the color.
     *
     * @return array
     *   The random color.
     */
    public function randomise()
    {
        $this->resetcolor();

        $this->setRed(ceil(mt_rand(0, 255)));
        $this->setGreen(ceil(mt_rand(0, 255)));
        $this->setBlue(ceil(mt_rand(0, 255)));

        return $this->getColorArray();
    }

    /**
     * Reset the color values. Useful when randomising the color or calculating new values.
     */
    private function resetColor()
    {
        $this->red = null;
        $this->green = null;
        $this->blue = null;

        $this->resetColorGeometry();
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
        $this->hue = null;
        $this->hue2 = null;

        $this->croma = null;
        $this->croma2 = null;

        $this->value = null;
        $this->lightness = null;
        $this->intensity = null;

        $this->luma = null;

        $this->hsv_saturation = null;
        $this->hsl_saturation = null;
        $this->hsi_saturation = null;
    }

    /**
     * Get a standard array of red, green, and blue.
     *
     * @return array A standard RGB color array.
     */
    public function getColorArray()
    {
        return array(
            'red',
            'green',
            'blue'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getHex();
    }

    /**
     * Generate a hex value of the color based on the current RGB values.
     *
     * @return string
     *   The hex value.
     */
    public function getHex()
    {
        $rgb['red'] = str_pad(dechex($this->getRed()), 2, '0', STR_PAD_LEFT);
        $rgb['green'] = str_pad(dechex($this->getGreen()), 2, '0', STR_PAD_LEFT);
        $rgb['blue'] = str_pad(dechex($this->getBlue()), 2, '0', STR_PAD_LEFT);

        return strtoupper(implode($rgb));
    }

    /**
     * Convenience method that renders out the color statistics for this color.
     *
     * @return string
     *   The full statistics of the color.
     */
    public function renderColorStatistics()
    {
        $output = '';

        $output .= 'Red: ' . $this->getRed() . PHP_EOL;
        $output .= 'Green: ' . $this->getGreen() . PHP_EOL;
        $output .= 'Blue: ' . $this->getBlue() . PHP_EOL;
        $output .= 'Hex: ' . $this->getHex() . PHP_EOL;
        $output .= 'Croma: ' . $this->getCroma() . PHP_EOL;
        $output .= 'Croma2: ' . $this->getCroma2() . PHP_EOL;
        $output .= 'Hue: ' . $this->getHue() . PHP_EOL;
        $output .= 'Hue2: ' . $this->getHue2() . PHP_EOL;
        $output .= 'Hsi Saturation: ' . $this->getHsiSaturation() . PHP_EOL;
        $output .= 'Hsl Saturation: ' . $this->getHslSaturation() . PHP_EOL;
        $output .= 'Hsv Saturation: ' . $this->getHsvSaturation() . PHP_EOL;
        $output .= 'Intensity: ' . $this->getIntensity() . PHP_EOL;
        $output .= 'Lightness: ' . $this->getLightness() . PHP_EOL;
        $output .= 'Value: ' . $this->getValue() . PHP_EOL;

        return $output;
    }
}
