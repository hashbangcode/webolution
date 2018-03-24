<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Evolution\Population\Decorators\PopulationDecoratorFactory;

class PopulationDecoratorFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider populationDecoratorFactoryDataProvider
     */
    public function testFindPopulationDecorator($populationClass, $type, $decoratorClass)
    {
        $populationObject = new $populationClass();
        $decorator = PopulationDecoratorFactory::getPopulationDecorator($populationObject, $type);
        $this->assertInstanceOf($decoratorClass, $decorator);
    }

    /**
     * Data provider for testFindPopulation.
     *
     * @return array
     */
    public function populationDecoratorFactoryDataProvider()
    {

        return [
            [
                '\Hashbangcode\Wevolution\Evolution\Population\NumberPopulation',
                'Cli',
                '\Hashbangcode\Wevolution\Evolution\Population\Decorators\NumberPopulationDecoratorCli'
            ],
            [
                '\Hashbangcode\Wevolution\Evolution\Population\NumberPopulation',
                'Html',
                '\Hashbangcode\Wevolution\Evolution\Population\Decorators\NumberPopulationDecoratorHtml'
            ],
            [
                '\Hashbangcode\Wevolution\Evolution\Population\ColorPopulation',
                'Cli',
                '\Hashbangcode\Wevolution\Evolution\Population\Decorators\ColorPopulationDecoratorCli'
            ],
            [
                '\Hashbangcode\Wevolution\Evolution\Population\ColorPopulation',
                'Html',
                '\Hashbangcode\Wevolution\Evolution\Population\Decorators\ColorPopulationDecoratorHtml'
            ],
            [
                '\Hashbangcode\Wevolution\Evolution\Population\ColorPopulation',
                'cli',
                '\Hashbangcode\Wevolution\Evolution\Population\Decorators\ColorPopulationDecoratorCli'
            ],
            [
                '\Hashbangcode\Wevolution\Evolution\Population\ColorPopulation',
                'html',
                '\Hashbangcode\Wevolution\Evolution\Population\Decorators\ColorPopulationDecoratorHtml'
            ],
        ];
    }

    public function testNotFindPopulationDecorator()
    {
        $exception = '\Hashbangcode\Wevolution\Evolution\Population\Decorators\Exception\DecoratorNotFoundException';
        $this->expectException($exception);

        $numberPopulationClass = '\Hashbangcode\Wevolution\Evolution\Population\ColorPopulation';
        $type = 'Something';

        $numberPopulation = new $numberPopulationClass();
        $decorator = PopulationDecoratorFactory::getPopulationDecorator($numberPopulation, $type);
    }
}
