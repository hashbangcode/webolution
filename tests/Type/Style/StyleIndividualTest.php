<?php

namespace Hashbangcode\Webolution\Test\Type\Style;

use Hashbangcode\Webolution\Type\Style\StyleIndividual;
use Hashbangcode\Webolution\Type\Style\Style;
use Hashbangcode\Webolution\Type\Color\ColorIndividual;
use PHPUnit\Framework\TestCase;

class StyleIndividualTest extends TestCase
{

    public function testCreateIndividual()
    {
        $object = StyleIndividual::generateFromSelector('.div');
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Style\StyleIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Style\Style', $object->getObject());
        $this->assertEquals('.div', $object->getObject()->getSelector());
    }

    public function testCreateIndividualWithStyleObject()
    {
        $style = new Style('.div');
        $object = new StyleIndividual($style);
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Style\StyleIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Style\Style', $object->getObject());
        $this->assertEquals('.div', $object->getObject()->getSelector());
    }

    public function testAddAttributeCreatesASingleAttribute()
    {
        $object = StyleIndividual::generateFromSelector('.div');
        $object->addAttribute();
        $attributes = $object->getObject()->getAttributes();
        $this->assertEquals(1, count($attributes));

        $this->assertEquals('.div', $object->getName());
        $this->assertEquals('1', $object->getSpecies());
    }

    public function testIsSelectorId()
    {
        $object = StyleIndividual::generateFromSelector('#thing');
        $this->assertTrue(true, $object->isSelectorId());
    }

    public function testFitness()
    {
        $object = StyleIndividual::generateFromSelector('.div');
        $object->addAttribute();
        $this->assertEquals(2, $object->getFitness());
    }
}
