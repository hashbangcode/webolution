<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\IndividualDecoratorFactory;
use Prophecy\Prophet;

class IndividualDecoratorFactoryTest extends \PHPUnit_Framework_TestCase
{
    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testFindNumberIndividualDecoratorCli()
    {
        $typeObject = new \Hashbangcode\Wevolution\Type\Number\Number(1);
        $individualObject = new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual($typeObject);
        $decorator = IndividualDecoratorFactory::getIndividualDecorator($individualObject, 'cli');
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Individual\Decorators\NumberIndividualDecoratorCli', $decorator);
    }

    public function testFindNumberIndividualDecoratorHtml()
    {
        $typeObject = new \Hashbangcode\Wevolution\Type\Number\Number(1);
        $individualObject = new \Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual($typeObject);
        $decorator = IndividualDecoratorFactory::getIndividualDecorator($individualObject, 'html');
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Individual\Decorators\NumberIndividualDecoratorHtml', $decorator);
    }

    public function testFindColorIndividualDecoratorHtml()
    {
        $typeObject = new \Hashbangcode\Wevolution\Type\Color\Color(1, 1, 1);
        $individualObject = new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual($typeObject);
        $decorator = IndividualDecoratorFactory::getIndividualDecorator($individualObject, 'html');
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Individual\Decorators\ColorIndividualDecoratorHtml', $decorator);
    }

    public function testNotFindIndividualDecorator()
    {
        $exception = '\Hashbangcode\Wevolution\Evolution\Individual\Decorators\Exception\IndividualDecoratorNotFoundException';
        $this->expectException($exception);

        $typeObject = new \Hashbangcode\Wevolution\Type\Color\Color(1, 1, 1);
        $individualObject = new \Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual($typeObject);
        $decorator = IndividualDecoratorFactory::getIndividualDecorator($individualObject, 'something');
    }
}
