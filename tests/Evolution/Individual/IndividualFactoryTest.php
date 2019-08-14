<?php

namespace Hashbangcode\Webolution\Test\Evolution\Individual;

use Hashbangcode\Webolution\Evolution\Individual\IndividualFactory;

class IndividualFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testFindNumberIndividual()
    {
        $typeObject = new \Hashbangcode\Webolution\Type\Number\Number(1);
        $individual = IndividualFactory::getIndividual($typeObject);
        $this->assertInstanceOf('\Hashbangcode\Webolution\Evolution\Individual\NumberIndividual', $individual);
    }

    public function testFindColorIndividual()
    {
        $typeObject = new \Hashbangcode\Webolution\Type\Color\Color(1, 1, 1);
        $individual = IndividualFactory::getIndividual($typeObject);
        $this->assertInstanceOf('\Hashbangcode\Webolution\Evolution\Individual\ColorIndividual', $individual);
    }

    public function testFindTextIndividual()
    {
        $typeObject = new \Hashbangcode\Webolution\Type\Text\Text('abc');
        $individual = IndividualFactory::getIndividual($typeObject);
        $this->assertInstanceOf('\Hashbangcode\Webolution\Evolution\Individual\TextIndividual', $individual);
    }
}
