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
    }

    public function testCreateIndividualWithObject()
    {
        $style = new Style('.div');
        $object = new StyleIndividual($style);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Style\Style', $object->getObject());
    }
}
