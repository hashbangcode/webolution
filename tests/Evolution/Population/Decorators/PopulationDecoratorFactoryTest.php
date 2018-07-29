<?php

namespace Hashbangcode\Webolution\Test\Evolution\Population\Decorators;

use Hashbangcode\Webolution\Evolution\Population\Decorators\PopulationDecoratorFactory;

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
                '\Hashbangcode\Webolution\Evolution\Population\NumberPopulation',
                'Cli',
                '\Hashbangcode\Webolution\Evolution\Population\Decorators\NumberPopulationDecoratorCli'
            ],
            [
                '\Hashbangcode\Webolution\Evolution\Population\NumberPopulation',
                'Html',
                '\Hashbangcode\Webolution\Evolution\Population\Decorators\NumberPopulationDecoratorHtml'
            ],
            [
                '\Hashbangcode\Webolution\Evolution\Population\ColorPopulation',
                'Cli',
                '\Hashbangcode\Webolution\Evolution\Population\Decorators\ColorPopulationDecoratorCli'
            ],
            [
                '\Hashbangcode\Webolution\Evolution\Population\ColorPopulation',
                'Html',
                '\Hashbangcode\Webolution\Evolution\Population\Decorators\ColorPopulationDecoratorHtml'
            ],
            [
                '\Hashbangcode\Webolution\Evolution\Population\ColorPopulation',
                'cli',
                '\Hashbangcode\Webolution\Evolution\Population\Decorators\ColorPopulationDecoratorCli'
            ],
            [
                '\Hashbangcode\Webolution\Evolution\Population\ColorPopulation',
                'html',
                '\Hashbangcode\Webolution\Evolution\Population\Decorators\ColorPopulationDecoratorHtml'
            ],
        ];
    }

    public function testNotFindPopulationDecorator()
    {
        $exception = '\Hashbangcode\Webolution\Evolution\Population\Decorators\Exception\PopulationDecoratorNotFoundException';
        $this->expectException($exception);

        $numberPopulationClass = '\Hashbangcode\Webolution\Evolution\Population\ColorPopulation';
        $type = 'Something';

        $numberPopulation = new $numberPopulationClass();
        $decorator = PopulationDecoratorFactory::getPopulationDecorator($numberPopulation, $type);
    }
}
