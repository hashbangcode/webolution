<?php

namespace Hashbangcode\Webolution\Test\Population\Decorators;

use Hashbangcode\Webolution\PopulationDecoratorFactory;

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
                '\Hashbangcode\Webolution\Type\Number\NumberPopulation',
                'Cli',
                '\Hashbangcode\Webolution\Type\Number\Decorator\NumberPopulationDecoratorCli'
            ],
            [
                '\Hashbangcode\Webolution\Type\Number\NumberPopulation',
                'Html',
                '\Hashbangcode\Webolution\Type\Number\Decorator\NumberPopulationDecoratorHtml'
            ],
            [
                '\Hashbangcode\Webolution\Type\Color\ColorPopulation',
                'Cli',
                '\Hashbangcode\Webolution\Type\Color\Decorator\ColorPopulationDecoratorCli'
            ],
            [
                '\Hashbangcode\Webolution\Type\Color\ColorPopulation',
                'Html',
                '\Hashbangcode\Webolution\Type\Color\Decorator\ColorPopulationDecoratorHtml'
            ],
            [
                '\Hashbangcode\Webolution\Type\Color\ColorPopulation',
                'cli',
                '\Hashbangcode\Webolution\Type\Color\Decorator\ColorPopulationDecoratorCli'
            ],
            [
                '\Hashbangcode\Webolution\Type\Color\ColorPopulation',
                'html',
                '\Hashbangcode\Webolution\Type\Color\Decorator\ColorPopulationDecoratorHtml'
            ],
        ];
    }

    public function testNotFindPopulationDecorator()
    {
        $exception = '\Hashbangcode\Webolution\Exception\PopulationDecoratorNotFoundException';
        $this->expectException($exception);

        $numberPopulationClass = '\Hashbangcode\Webolution\Type\Color\ColorPopulation';
        $type = 'Something';

        $numberPopulation = new $numberPopulationClass();
        $decorator = PopulationDecoratorFactory::getPopulationDecorator($numberPopulation, $type);
    }
}
