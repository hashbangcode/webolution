<?php

namespace Hashbangcode\Webolution\Test\Evolution\Individual\Decorators;

use Hashbangcode\Webolution\Evolution\Individual\Decorators\IndividualDecoratorFactory;
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
        $typeObject = new \Hashbangcode\Webolution\Type\Number\Number(1);
        $individualObject = new \Hashbangcode\Webolution\Evolution\Individual\NumberIndividual($typeObject);
        $decorator = IndividualDecoratorFactory::getIndividualDecorator($individualObject, 'cli');
        $this->assertInstanceOf('\Hashbangcode\Webolution\Evolution\Individual\Decorators\NumberIndividualDecoratorCli', $decorator);
    }

    public function testFindNumberIndividualDecoratorHtml()
    {
        $typeObject = new \Hashbangcode\Webolution\Type\Number\Number(1);
        $individualObject = new \Hashbangcode\Webolution\Evolution\Individual\NumberIndividual($typeObject);
        $decorator = IndividualDecoratorFactory::getIndividualDecorator($individualObject, 'html');
        $this->assertInstanceOf('\Hashbangcode\Webolution\Evolution\Individual\Decorators\NumberIndividualDecoratorHtml', $decorator);
    }

    public function testFindColorIndividualDecoratorHtml()
    {
        $typeObject = new \Hashbangcode\Webolution\Type\Color\Color(1, 1, 1);
        $individualObject = new \Hashbangcode\Webolution\Evolution\Individual\ColorIndividual($typeObject);
        $decorator = IndividualDecoratorFactory::getIndividualDecorator($individualObject, 'html');
        $this->assertInstanceOf('\Hashbangcode\Webolution\Evolution\Individual\Decorators\ColorIndividualDecoratorHtml', $decorator);
    }

    public function testNotFindIndividualDecorator()
    {
        $exception = '\Hashbangcode\Webolution\Evolution\Individual\Decorators\Exception\IndividualDecoratorNotFoundException';
        $this->expectException($exception);

        $typeObject = new \Hashbangcode\Webolution\Type\Color\Color(1, 1, 1);
        $individualObject = new \Hashbangcode\Webolution\Evolution\Individual\ColorIndividual($typeObject);
        $decorator = IndividualDecoratorFactory::getIndividualDecorator($individualObject, 'something');
    }
}
