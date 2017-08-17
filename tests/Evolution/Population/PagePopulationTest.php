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

    public function testCreateActivePopulation()
    {
        $object = PageIndividual::generateBlankPage();

        $style = new \Hashbangcode\Wevolution\Type\Style\Style('div');
        $style->setAttribute('color', 'red');
        $object->getObject()->setStyle($style);

        $body = new \Hashbangcode\Wevolution\Type\Element\Element('div');
        $object->getObject()->setBody($body);

        $population = new PagePopulation();
        $population->addIndividual($object);

        $output = $population->render();
        $this->assertStringEqualsFile('tests/Evolution/Population/data/page01.html', $output);
    }
}
