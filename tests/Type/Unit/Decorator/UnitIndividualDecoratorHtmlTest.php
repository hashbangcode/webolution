<?php

namespace Hashbangcode\Webolution\Test\Type\Unit\Decorator;

use Hashbangcode\Webolution\Type\Unit\Decorator\UnitIndividualDecoratorHtml;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class UnitIndividualDecoratorHtmlTest extends TestCase
{
    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Unit\UnitIndividual');
        $individualDecorator = new UnitIndividualDecoratorHtml($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Unit\Decorator\UnitIndividualDecoratorHtml', $individualDecorator);
    }

    /**
     * @dataProvider unitRenderDataProvider
     */
    public function testRender($number, $unit, $expectedRender)
    {
        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Unit\Unit');
        $object->getUnit()->willReturn($unit);
        $object->getNumber()->willReturn($number);

        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Unit\UnitIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $individualDecorator = new UnitIndividualDecoratorHtml($objectIndividual->reveal());
        $render = $individualDecorator->render();
        $this->assertEquals($expectedRender, $render);
    }


    public function unitRenderDataProvider()
    {
        return [
            [1, 'px', '1px'],
            [50, 'px', '50px'],
            [-1, 'px', '-1px'],
            [1, 'em', '1em'],
            [100, 'em', '100em'],
            [1, '%', '1%'],
            [123, '%', '123%'],
            [1, 'auto', 'auto'],
        ];
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
