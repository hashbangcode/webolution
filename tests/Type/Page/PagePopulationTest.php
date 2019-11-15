<?php

namespace Hashbangcode\Webolution\Test\Population;

use Hashbangcode\Webolution\Type\Page\PagePopulation;
use Hashbangcode\Webolution\Type\Page\PageIndividual;
use Hashbangcode\Webolution\Type\Page\Page;

class PagePopulationTest extends \PHPUnit_Framework_TestCase
{


    public function testCreateObject()
    {
        $object = new PagePopulation();
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Page\PagePopulation', $object);
    }

    public function testCreatePopulationWithElement()
    {
        $object = new PagePopulation();
        $object->addIndividual();
        $individual = $object->getIndividuals()[0];
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Page\PageIndividual', $individual);
    }
}
