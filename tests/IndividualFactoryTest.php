<?php

namespace Hashbangcode\Webolution\Test;

use Hashbangcode\Webolution\IndividualFactory;
use PHPUnit\Framework\TestCase;

class IndividualFactoryTest extends TestCase
{

    public function testFindNumberIndividual()
    {
        $typeObject = new \Hashbangcode\Webolution\Type\Number\Number(1);
        $individual = IndividualFactory::getIndividual($typeObject);
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Number\NumberIndividual', $individual);
    }

    public function testFindColorIndividual()
    {
        $typeObject = new \Hashbangcode\Webolution\Type\Color\Color(1, 1, 1);
        $individual = IndividualFactory::getIndividual($typeObject);
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Color\ColorIndividual', $individual);
    }

    public function testFindTextIndividual()
    {
        $typeObject = new \Hashbangcode\Webolution\Type\Text\Text('abc');
        $individual = IndividualFactory::getIndividual($typeObject);
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Text\TextIndividual', $individual);
    }
}
