<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Population\PagePopulation;
use Hashbangcode\Wevolution\Evolution\Individual\PageIndividual;
use Hashbangcode\Wevolution\Type\Page\Page;

class PagePopulationTest extends \PHPUnit_Framework_TestCase
{


    public function testCreateObject()
    {
        $object = new PagePopulation();
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Population\PagePopulation', $object);
    }

    public function testCreatePopulationWithElement()
    {
        $object = new PagePopulation();
        $object->addIndividual();
        $individual = $object->getIndividuals()[0];
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\PageIndividual', $individual);
    }
}
