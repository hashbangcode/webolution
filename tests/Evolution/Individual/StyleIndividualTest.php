<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual;

use Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual;
use Hashbangcode\Wevolution\Type\Style\Style;
use Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual;

/**
 * Test class for ColorIndividual
 */
class StyleIndividualTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateIndividual()
    {
        $object = StyleIndividual::generateFromSelector('.div');
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Style\Style', $object->getObject());
        $this->assertEquals('.div', $object->getObject()->getSelector());
    }

    public function testCreateIndividualWithStyleObject()
    {
        $style = new Style('.div');
        $object = new StyleIndividual($style);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Style\Style', $object->getObject());
        $this->assertEquals('.div', $object->getObject()->getSelector());
    }

    public function testAddAttributeCreatesASingleAttribute()
    {
        $object = StyleIndividual::generateFromSelector('.div');
        $object->addAttribute();
        $attributes = $object->getObject()->getAttributes();
        $this->assertEquals(1, count($attributes));
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
