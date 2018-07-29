<?php

namespace Hashbangcode\Webolution\Test\Evolution\Population;

use Hashbangcode\Webolution\Evolution\Population\PagePopulation;
use Hashbangcode\Webolution\Evolution\Individual\PageIndividual;
use Hashbangcode\Webolution\Type\Page\Page;

class PagePopulationTest extends \PHPUnit_Framework_TestCase
{


    public function testCreateObject()
    {
        $object = new PagePopulation();
        $this->assertInstanceOf('Hashbangcode\Webolution\Evolution\Population\PagePopulation', $object);
    }

    public function testCreatePopulationWithElement()
    {
        $object = new PagePopulation();
        $object->addIndividual();
        $individual = $object->getIndividuals()[0];
        $this->assertInstanceOf('Hashbangcode\Webolution\Evolution\Individual\PageIndividual', $individual);
    }
}
