<?php

namespace Hashbangcode\Webolution\Test\Type\Style\Decorator;

use Hashbangcode\Webolution\Type\Style\Decorator\StyleIndividualDecoratorCli;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class StyleIndividualDecoratorCliTest extends TestCase
{
    private $prophet;

    public function setup(): void
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Style\StyleIndividual');
        $individualDecorator = new StyleIndividualDecoratorCli($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Style\Decorator\StyleIndividualDecoratorCli', $individualDecorator);
    }

    public function testRenderSimpleStyle()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Style\Style');
        $object->getSelector()->willReturn('.test');
        $object->getAttributes()->willReturn([
            'background' => 'black',
        ]);

        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Style\StyleIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new StyleIndividualDecoratorCli($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();

        $this->assertEquals('.test{background:black;}', $render);
    }

    public function testRenderComplexStyle()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Style\Style');
        $object->getSelector()->willReturn('div.test');
        $object->getAttributes()->willReturn([
            'background' => 'black',
            'color' => 'red',
            'padding' => '0px',
            'margin' => '0px',
            'font-family' => "'Ubuntu',sans-serif",
        ]);

        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Style\StyleIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new StyleIndividualDecoratorCli($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();

        $this->assertEquals('div.test{background:black;color:red;padding:0px;margin:0px;font-family:\'Ubuntu\',sans-serif;}', $render);
    }

    public function testRenderObjectStyle()
    {
        $unit1 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Unit\Unit');
        $unit1->getNumber()->willReturn('1');
        $unit1->getUnit()->willReturn('px');

        $unitIndividual = new \Hashbangcode\Webolution\Type\Unit\UnitIndividual($unit1->reveal());

        //$unitIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Unit\UnitIndividual');
        //$unitIndividual->getObject()->willReturn($unit1->reveal());

        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Style\Style');
        $object->getSelector()->willReturn('div.test');
        $object->getAttributes()->willReturn([
            'background' => 'black',
            'color' => 'red',
            'padding' => '0px',
            'margin' => [
                $unitIndividual,
            ],
        ]);

        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Style\StyleIndividual');
        $objectIndividual->getObject()->willReturn($object->reveal());

        $objectIndividualDecorator = new StyleIndividualDecoratorCli($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();

        $this->assertEquals('div.test{background:black;color:red;padding:0px;margin:1px;}', $render);
    }

    protected function tearDown(): void
    {
        $this->prophet->checkPredictions();
    }
}
