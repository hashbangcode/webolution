<?php

namespace Hashbangcode\Webolution\Test;

use Hashbangcode\Webolution\IndividualDecoratorFactory;
use Hashbangcode\Webolution\Type\Number\Number;
use Hashbangcode\Webolution\Type\Color\Color;
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
        $individualObject = new \Hashbangcode\Webolution\Type\Number\NumberIndividual($typeObject);
        $decorator = IndividualDecoratorFactory::getIndividualDecorator($individualObject, 'cli');
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Number\Decorator\NumberIndividualDecoratorCli', $decorator);
    }

    public function testFindNumberIndividualDecoratorHtml()
    {
        $typeObject = new \Hashbangcode\Webolution\Type\Number\Number(1);
        $individualObject = new \Hashbangcode\Webolution\Type\Number\NumberIndividual($typeObject);
        $decorator = IndividualDecoratorFactory::getIndividualDecorator($individualObject, 'html');
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Number\Decorator\NumberIndividualDecoratorHtml', $decorator);
    }

    public function testFindColorIndividualDecoratorHtml()
    {
        $typeObject = new \Hashbangcode\Webolution\Type\Color\Color(1, 1, 1);
        $individualObject = new \Hashbangcode\Webolution\Type\Color\ColorIndividual($typeObject);
        $decorator = IndividualDecoratorFactory::getIndividualDecorator($individualObject, 'html');
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Color\Decorator\ColorIndividualDecoratorHtml', $decorator);
    }

    public function testNotFindIndividualDecorator()
    {
        $exception = '\Hashbangcode\Webolution\Exception\IndividualDecoratorNotFoundException';
        $this->expectException($exception);

        $typeObject = new \Hashbangcode\Webolution\Type\Color\Color(1, 1, 1);
        $individualObject = new \Hashbangcode\Webolution\Type\Color\ColorIndividual($typeObject);
        $decorator = IndividualDecoratorFactory::getIndividualDecorator($individualObject, 'something');
    }
}
