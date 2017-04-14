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
     * @return \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual
     */
    public static function generateRandomColor()
    {
        // Return an RGB array.
        $red = ceil(mt_rand(0, 255));
        $green = ceil(mt_rand(0, 255));
        $blue = ceil(mt_rand(0, 255));

        return new ColorIndividual($red, $green, $blue);
    }

    /**
     * @param $color \Hashbangcode\Wevolution\Type\Color\Color
     *   The Colour object to use when creating the ColorIndividual.
     *
     * @return ColorIndividual
     *   A new ColorIndividual object.
     */
    public static function generateFromColor($color)
    {
        return new ColorIndividual($color->getRed(), $color->getGreen(), $color->getBlue());
    }

    /**
     * Generate a ColorIndividual object from a hex value.
     *
     * @param $hex
     * @return ColorIndividual
     */
    public static function generateFromHex($hex)
    {
        $color = Color::generateFromHex($hex);
        return self::generateFromColor($color);
    }

    /**
     *
     */
    public function mutateProperties()
    {
        $this->mutateColor($this->getMutationFactor());
        return $this;
    }

    /**
     * Tweak a value in the RGB matrix for the color.
     *
     * @param int $amount The amount of alteration to make. Note that the RGB value of the color can't exceed 255 or be
     * less than 0. If this situation occurs the amounts are restricted.
     *
     * @return $this The current object.
     */
    public function mutateColor($mutationFactor)
    {

        if (mt_rand(0, 100) < $mutationFactor) {
            $amount = mt_rand(1, 15);

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
     * @return float
     */
    public function getFitness()
    {
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
            case 'css':
                return '#' . $this->object->render();
            case 'cli':
            default:
                return $this->object->render() . PHP_EOL;
        }
    }
}