<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\StyleIndividualDecoratorHtml;
use Prophecy\Prophet;

class StyleIndividualDecoratorHtmlTest extends \PHPUnit_Framework_TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual');
        $individualDecorator = new StyleIndividualDecoratorHtml($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Individual\Decorators\StyleIndividualDecoratorHtml', $individualDecorator);
    }

    public function testRenderSimpleStyle()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Style\Style');
        $object->getSelector()->willReturn('.test');
        $object->getAttributes()->willReturn([
            'background' => 'black',
        ]);

        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new StyleIndividualDecoratorHtml($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();

        $this->assertEquals('.test{background:black;}', $render);
    }

    public function testRenderComplexStyle()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Style\Style');
        $object->getSelector()->willReturn('div.test');
        $object->getAttributes()->willReturn([
            'background' => 'black',
            'color' => 'red',
            'padding' => '0px',
            'margin' => '0px',
            'font-family' => "'Ubuntu',sans-serif",
        ]);

        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new StyleIndividualDecoratorHtml($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();

        $this->assertEquals('div.test{background:black;color:red;padding:0px;margin:0px;font-family:\'Ubuntu\',sans-serif;}', $render);
    }

    public function testRenderObjectStyle()
    {
        $unit1 = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Unit\Unit');
        $unit1->getNumber()->willReturn('1');
        $unit1->getUnit()->willReturn('px');

        $unitIndividual = new \Hashbangcode\Wevolution\Evolution\Individual\UnitIndividual($unit1->reveal());

        //$unitIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\UnitIndividual');
        //$unitIndividual->getObject()->willReturn($unit1->reveal());

        $object = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Style\Style');
        $object->getSelector()->willReturn('div.test');
        $object->getAttributes()->willReturn([
            'background' => 'black',
            'color' => 'red',
            'padding' => '0px',
            'margin' => [
                $unitIndividual,
            ],
        ]);

        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual');
        $objectIndividual->getObject()->willReturn($object->reveal());

        $objectIndividualDecorator = new StyleIndividualDecoratorHtml($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();

        $this->assertEquals('div.test{background:black;color:red;padding:0px;margin:1px;}', $render);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
