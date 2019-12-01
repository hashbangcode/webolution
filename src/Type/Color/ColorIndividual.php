<?php

namespace Hashbangcode\Webolution\Type\Color;

use Hashbangcode\Webolution\Individual;

/**
 * Class ColorIndividual.
 *
 * @package Hashbangcode\Webolution\Individual
 */
class ColorIndividual extends Individual
{
    /**
     * ColorIndividual constructor.
     *
     * @param int $red
     *   The red value of the color.
     * @param int $green
     *   The green value of the color.
     * @param int $blue
     *   The blue value of the color.
     *
     * @return ColorIndividual
     *   A new ColorIndividual object.
     *
     * @throws \Hashbangcode\Webolution\Type\Color\Exception\InvalidRGBValueException
     */
    public static function generateFromRgb($red, $green, $blue)
    {
        // Create the Color object.
        $color = new Color($red, $green, $blue);

        // Generate and return the ColorIndividual object.
        return new self($color);
    }

    /**
     * Generate a ColorIndividual object containing a Color object with random color.
     *
     * @return ColorIndividual
     *   The ColorIndividual object with a Color object with random RGB values.
     *
     * @throws \Hashbangcode\Webolution\Type\Color\Exception\InvalidRGBValueException
     */
    public static function generateRandomColor()
    {
        return new self(ColorFactory::generateRandom());
    }

    /**
     * Generate a ColorIndividual object containing a Color object from a hex value.
     *
     * @param string $hex
     *   The hex value.
     *
     * @return ColorIndividual
     *   A ColorIndividual object.
     *
     * @throws \Hashbangcode\Webolution\Type\Color\Exception\InvalidRGBValueException
     */
    public static function generateFromHex($hex)
    {
        return new self(ColorFactory::generateFromHex($hex));
    }

    /**
     * {@inheritdoc}
     */
    public function mutate($mutationFactor = 0, $mutationAmount = 1)
    {
        if (mt_rand(0, 100) < $mutationFactor) {
            $rgb = $this->getObject()->getColorArray();

            $rgb_key = ucfirst($rgb[array_rand($rgb)]);

            $operators = ['add', 'subtract'];

            switch ($operators[array_rand($operators)]) {
                case 'add':
                    $value = $this->getObject()->{'get' . $rgb_key}() + $mutationAmount;
                    break;
                case 'subtract':
                default:
                    $value = $this->getObject()->{'get' . $rgb_key}() - $mutationAmount;
                    break;
            }

            if (0 > $value) {
                $value = 0;
            } else {
                if (255 < $value) {
                    $value = 255;
                }
            }

            $this->getObject()->{'set' . $rgb_key}($value);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFitness($type = '')
    {
        // Get the color object.
        $color = $this->getObject();

        switch ($type) {
            // Lightness is a value between 0 and 1.
            case 'hue':
                return $color->getHue();
            case 'saturation':
                return $color->getHsvSaturation();
            case 'value':
                return $color->getValue();
            case 'lightness':
                return $color->getLightness();
            default:
                return abs($color->getLightness() * 10);
        }
    }
}
