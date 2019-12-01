<?php

namespace Hashbangcode\Webolution\Type\Color;

use Hashbangcode\Webolution\TypeFactoryInterface;
use Hashbangcode\Webolution\Type\TypeInterface;

/**
 * Class ColorFactory.
 *
 * @package Hashbangcode\Webolution\Type\Color
 */
class ColorFactory implements TypeFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public static function generateRandom(): TypeInterface
    {
        $red = (int)ceil(mt_rand(0, 255));
        $green = (int)ceil(mt_rand(0, 255));
        $blue = (int)ceil(mt_rand(0, 255));

        return new Color($red, $blue, $green);
    }

    /**
     * Generate a Color object from a hex value.
     *
     * @param string $hex
     *   The vex value. May, or may not contain a # in front.
     *
     * @return \Hashbangcode\Webolution\Type\Color\Color
     *   The new colour object.
     *
     * @throws Exception\InvalidRGBValueException
     */
    public static function generateFromHex($hex)
    {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $red = (int)hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $green = (int)hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $blue = (int)hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $red = (int)hexdec(substr($hex, 0, 2));
            $green = (int)hexdec(substr($hex, 2, 2));
            $blue = (int)hexdec(substr($hex, 4, 2));
        }

        return new Color($red, $green, $blue);
    }

    /**
     * Generate a Color from HSV values.
     *
     * @param int $hue
     *   The hue.
     * @param float $saturation
     *   The saturation.
     * @param float $value
     *   The value.
     *
     * @return \Hashbangcode\Webolution\Type\Color\Color
     *   A new Color object.
     *
     * @throws Exception\InvalidRGBValueException
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

        $red = (int)round(($red + $match) * 255);
        $green = (int)round(($green + $match) * 255);
        $blue = (int)round(($blue + $match) * 255);

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
     *   The hue.
     * @param float $saturation
     *   The saturation.
     * @param float $lightness
     *   The lightness.
     *
     * @return \Hashbangcode\Webolution\Type\Color\Color
     *   A new Color object.
     *
     * @throws Exception\InvalidRGBValueException
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

        $red = (int)round(($red + $match) * 255);
        $green = (int)round(($green + $match) * 255);
        $blue = (int)round(($blue + $match) * 255);

        $new_color = new Color($red, $green, $blue);
        $new_color->setHue($hue);
        $new_color->setHslSaturation($saturation);
        $new_color->setLightness($lightness);
        return $new_color;
    }
}
