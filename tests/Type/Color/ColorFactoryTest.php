<?php

namespace Hashbangcode\Webolution\Test\Type\Color;

use Hashbangcode\Webolution\Type\Color\Color;
use Hashbangcode\Webolution\Type\Color\ColorFactory;
use Hashbangcode\Webolution\Type\Color\Exception;
use PHPUnit\Framework\TestCase;

/**
 * Test class for ColorFactory.
 */
class ColorFactoryTest extends TestCase
{
    public function testGenerateRandom()
    {
        $color = ColorFactory::generateRandom();
        $this->assertInstanceOf(Color::class, $color);

        $this->assertGreaterThanOrEqual(0, $color->getRed());
        $this->assertLessThanOrEqual(255, $color->getRed());

        $this->assertGreaterThanOrEqual(0, $color->getGreen());
        $this->assertLessThanOrEqual(255, $color->getGreen());

        $this->assertGreaterThanOrEqual(0, $color->getBlue());
        $this->assertLessThanOrEqual(255, $color->getBlue());
    }

    public function testGenerateColorFromHex()
    {
        $color = ColorFactory::generateFromHex('FFFFFF');

        $this->assertEquals('255', $color->getRed());
        $this->assertEquals('255', $color->getGreen());
        $this->assertEquals('255', $color->getBlue());
        $this->assertEquals('255255255', $color->getRGB());
    }

    public function testGenerateFromHSL()
    {
        $color = ColorFactory::generateFromHSL(60, 1, 0.25);

        $this->assertEquals(128, $color->getRed());
        $this->assertEquals(128, $color->getGreen());
        $this->assertEquals(0, $color->getBlue());
        $this->assertEquals('128128000', $color->getRGB());
    }

    /**
     * @dataProvider colorData
     */
    public function testGenerateHexThenWithHSLWithDataProvider($hex, $rgb, $hsl)
    {
        $color1 = ColorFactory::generateFromHex($hex);

        $this->assertEquals($rgb[0], $color1->getRed());
        $this->assertEquals($rgb[1], $color1->getGreen());
        $this->assertEquals($rgb[2], $color1->getBlue());

        $this->assertEquals($hsl[0], round($color1->getHue(), 2));
        $this->assertEquals($hsl[1], round($color1->getHslSaturation(), 2));
        $this->assertEquals(round($hsl[2], 2), round($color1->getLightness(), 2));

        $color2 = ColorFactory::generateFromHSL($color1->getHue(), $color1->getHslSaturation(), $color1->getLightness());

        $this->assertEquals($rgb[0], $color2->getRed());
        $this->assertEquals($rgb[1], $color2->getGreen());
        $this->assertEquals($rgb[2], $color2->getBlue());

        $this->assertEquals($hsl[0], round($color2->getHue(), 2));
        $this->assertEquals($hsl[1], round($color2->getHslSaturation(), 2));
        $this->assertEquals(round($hsl[2], 2), round($color2->getLightness(), 2));
    }

    /**
     * @dataProvider colorData
     */
    public function testGenerateWithHsl($hex, $rgb, $hsl)
    {
        $color = ColorFactory::generateFromHSL($hsl[0], $hsl[1], $hsl[2]);

        $this->assertEquals($rgb[0], $color->getRed());
        $this->assertEquals($rgb[1], $color->getGreen());
        $this->assertEquals($rgb[2], $color->getBlue());

        $this->assertEquals($hsl[0], round($color->getHue(), 2));
        $this->assertEquals($hsl[1], round($color->getHslSaturation(), 2));
        $this->assertEquals(round($hsl[2], 2), round($color->getLightness(), 2));
    }

    /**
     * @dataProvider colorData
     */
    public function testGenerateWithHsv($hex, $rgb, $hsl)
    {
        $color1 = new Color($rgb[0], $rgb[1], $rgb[2]);

        $color2 = ColorFactory::generateFromHSV($color1->getHue(), $color1->getHsvSaturation(), $color1->getValue());

        $this->assertEquals($rgb[0], $color2->getRed());
        $this->assertEquals($rgb[1], $color2->getGreen());
        $this->assertEquals($rgb[2], $color2->getBlue());

        $this->assertEquals($hsl[0], round($color2->getHue(), 2));
        $this->assertEquals($hsl[1], round($color2->getHslSaturation(), 2));
        $this->assertEquals(round($hsl[2], 2), round($color2->getLightness(), 2));
    }

    /**
     * Data provider for color analysis.
     *
     * @return array
     */
    public function colorData()
    {
        return array(
            array('hex' => '000000', 'rgb' => array(0, 0, 0), 'hsl' => array(0, 0, 0)),
            array('hex' => 'FFFFFF', 'rgb' => array(255, 255, 255), 'hsl' => array(0, 0, 1)),
            array('hex' => 'FF0000', 'rgb' => array(255, 0, 0), 'hsl' => array(0, 1, 0.5)),
            array('hex' => '00FF00', 'rgb' => array(0, 255, 0), 'hsl' => array(120, 1, 0.5)),
            array('hex' => '0000FF', 'rgb' => array(0, 0, 255), 'hsl' => array(240, 1, 0.5)),
            array('hex' => 'FFFF00', 'rgb' => array(255, 255, 0), 'hsl' => array(60, 1, 0.5)),
            array('hex' => '00FFFF', 'rgb' => array(0, 255, 255), 'hsl' => array(180, 1, 0.5)),
            array('hex' => 'FF00FF', 'rgb' => array(255, 0, 255), 'hsl' => array(300, 1, 0.5)),
            array('hex' => 'C0C0C0', 'rgb' => array(192, 192, 192), 'hsl' => array(0, 0, 0.753)),
            array('hex' => '808080', 'rgb' => array(128, 128, 128), 'hsl' => array(0, 0, 0.5)),
            array('hex' => '800000', 'rgb' => array(128, 0, 0), 'hsl' => array(0, 1, 0.25)),
            array('hex' => '808000', 'rgb' => array(128, 128, 0), 'hsl' => array(60, 1, 0.25)),
            array('hex' => '008000', 'rgb' => array(0, 128, 0), 'hsl' => array(120, 1, 0.25)),
            array('hex' => '800080', 'rgb' => array(128, 0, 128), 'hsl' => array(300, 1, 0.25)),
            array('hex' => '008080', 'rgb' => array(0, 128, 128), 'hsl' => array(180, 1, 0.25)),
            array('hex' => '000080', 'rgb' => array(0, 0, 128), 'hsl' => array(240, 1, 0.25))
        );
    }

    /**
     * @dataProvider hexValues
     */
    public function testGernerateFromHex3($hex3, $hex6)
    {
        $color = ColorFactory::generateFromHex($hex3);

        $this->assertEquals($hex6, $color->getHex());
    }

    public function hexValues()
    {
        return array(
            array('hex3' => '000', 'hex6' => '000000'),
            array('hex3' => '100', 'hex6' => '110000'),
            array('hex3' => '010', 'hex6' => '001100'),
            array('hex3' => '001', 'hex6' => '000011'),
            array('hex3' => '123', 'hex6' => '112233'),
            array('hex3' => '333', 'hex6' => '333333'),
            array('hex3' => '07F', 'hex6' => '0077FF'),
            array('hex3' => '321', 'hex6' => '332211'),
            array('hex3' => 'F71', 'hex6' => 'FF7711'),
            array('hex3' => 'F00', 'hex6' => 'FF0000'),
            array('hex3' => 'ABC', 'hex6' => 'AABBCC'),
            array('hex3' => 'EFF', 'hex6' => 'EEFFFF'),
            array('hex3' => 'FFF', 'hex6' => 'FFFFFF'),
        );
    }
}
