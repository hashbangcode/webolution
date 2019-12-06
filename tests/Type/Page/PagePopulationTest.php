<?php

namespace Hashbangcode\Webolution\Test\Type\Page;

use Hashbangcode\Webolution\Type\Page\PagePopulation;
use Hashbangcode\Webolution\Type\Page\PageIndividual;
use Hashbangcode\Webolution\Type\Page\Page;
use PHPUnit\Framework\TestCase;

class PagePopulationTest extends TestCase
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

    public function testCrossOverAddsIndividual()
    {
        $object = new PagePopulation();
        $object->addIndividual();
        $object->addIndividual();
        $object->addIndividual();
        $object->crossover();
        $this->assertEquals(4, $object->getIndividualCount());
    }
}
