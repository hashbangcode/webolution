<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Population\PagePopulation;
use Hashbangcode\Wevolution\Evolution\Individual\PageIndividual;

class PagePopulationTest extends \PHPUnit_Framework_TestCase
{


    public function testCreateObject()
    {
        $object = new PagePopulation();
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Population\PagePopulation', $object);
    }

    public function testCreateActivePopulation()
    {
        $object = new PageIndividual();

        $style = new \Hashbangcode\Wevolution\Type\Style\Style('div');
        $style->setAttrbute('color', 'red');
        $object->getObject()->setStyle($style);

        $body = new \Hashbangcode\Wevolution\Type\Element\Element('div');
        $object->getObject()->setBody($body);

        $population = new PagePopulation();

        $output = $object->getObject()->render();

        $this->assertEquals($output, '<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
<style>div{color:red;}</style>
    </head>
    <body>
<div></div>
    </body>
</html>');
    }
}