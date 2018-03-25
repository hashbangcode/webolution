<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\IndividualDecoratorFactory;

class IndividualDecoratorFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider individualDecoratorFactoryDataProvider
     */
    public function testFindIndividualDecorator($individualClass, $type, $decoratorClass)
    {
        $individualObject = new $individualClass();
        $decorator = IndividualDecoratorFactory::getIndividualDecorator($individualObject, $type);
        $this->assertInstanceOf($decoratorClass, $decorator);
    }

    /**
     * Data provider for testFindIndividual.
     *
     * @return array
     */
    public function individualDecoratorFactoryDataProvider()
    {
        return [
            [
                '\Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual',
                'Cli',
                '\Hashbangcode\Wevolution\Evolution\Individual\Decorators\NumberIndividualDecoratorCli'
            ],
            [
                '\Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual',
                'Html',
                '\Hashbangcode\Wevolution\Evolution\Individual\Decorators\NumberIndividualDecoratorHtml'
            ],
            [
                '\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual',
                'Cli',
                '\Hashbangcode\Wevolution\Evolution\Individual\Decorators\ColorIndividualDecoratorCli'
            ],
            [
                '\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual',
                'Html',
                '\Hashbangcode\Wevolution\Evolution\Individual\Decorators\ColorIndividualDecoratorHtml'
            ],
            [
                '\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual',
                'cli',
                '\Hashbangcode\Wevolution\Evolution\Individual\Decorators\ColorIndividualDecoratorCli'
            ],
            [
                '\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual',
                'html',
                '\Hashbangcode\Wevolution\Evolution\Individual\Decorators\ColorIndividualDecoratorHtml'
            ],
        ];
    }

    public function testNotFindIndividualDecorator()
    {
        $exception = '\Hashbangcode\Wevolution\Evolution\Individual\Decorators\Exception\IndividualDecoratorNotFoundException';
        $this->expectException($exception);

        $numberIndividualClass = '\Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual';
        $type = 'Something';

        $numberIndividual = new $numberIndividualClass();
        $decorator = IndividualDecoratorFactory::getIndividualDecorator($numberIndividual, $type);
    }
}
