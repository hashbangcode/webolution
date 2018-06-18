<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\ImageIndividualDecoratorCli;
use Prophecy\Prophet;

class ImageIndividualDecoratorCliTest extends \PHPUnit_Framework_TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\ImageIndividual');
        $individualDecorator = new ImageIndividualDecoratorCli($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Individual\Decorators\ImageIndividualDecoratorCli', $individualDecorator);
    }

    public function testRender()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Image\Image');

        $imageMatrix = array_fill_keys(range(0, 9), 0);
        foreach ($imageMatrix as $id => $imagePart) {
            $imageMatrix[$id] = array_fill_keys(range(0, 9), 0);
        }

        $object->getImageMatrix()->willReturn($imageMatrix);
        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\ImageIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new ImageIndividualDecoratorCli($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();

        $this->assertStringEqualsFile('tests/Evolution/Individual/Decorators/data/image01.txt', $render);
    }

    public function testRenderWithPixelsSet()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Image\Image');

        $imageMatrix = array_fill_keys(range(0, 4), 1);
        foreach ($imageMatrix as $id => $imagePart) {
            $imageMatrix[$id] = array_fill_keys(range(0, 4), 0);
        }
        $imageMatrix[1][1] = 1;
        $imageMatrix[2][2] = 1;
        $imageMatrix[3][3] = 1;

        $object->getImageMatrix()->willReturn($imageMatrix);
        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\ImageIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new ImageIndividualDecoratorCli($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();

        $this->assertStringEqualsFile('tests/Evolution/Individual/Decorators/data/image02.txt', $render);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
