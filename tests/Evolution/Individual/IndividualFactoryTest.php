<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\IndividualFactory;

class IndividualFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testFindNumberIndividual()
    {
        $typeObject = new \Hashbangcode\Wevolution\Type\Number\Number(1);
        $individual = IndividualFactory::getIndividual($typeObject);
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual', $individual);
    }

    public function testFindColorIndividual()
    {
        $typeObject = new \Hashbangcode\Wevolution\Type\Color\Color(1, 1, 1);
        $individual = IndividualFactory::getIndividual($typeObject);
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual', $individual);
    }

    public function testFindTextIndividual()
    {
        $typeObject = new \Hashbangcode\Wevolution\Type\Text\Text('abc');
        $individual = IndividualFactory::getIndividual($typeObject);
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Individual\TextIndividual', $individual);
    }
}
