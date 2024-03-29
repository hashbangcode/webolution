<?php

namespace Hashbangcode\Webolution\Test\Type\Image\Decorator;

use Hashbangcode\Webolution\Type\Image\Decorator\ImageIndividualDecoratorCli;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class ImageIndividualDecoratorCliTest extends TestCase
{

    private $prophet;

    public function setup(): void
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Image\ImageIndividual');
        $individualDecorator = new ImageIndividualDecoratorCli($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Type\Image\Decorator\ImageIndividualDecoratorCli', $individualDecorator);
    }

    public function testRender()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Image\Image');

        $imageMatrix = array_fill_keys(range(0, 9), 0);
        foreach ($imageMatrix as $id => $imagePart) {
            $imageMatrix[$id] = array_fill_keys(range(0, 9), 0);
        }

        $object->getImageMatrix()->willReturn($imageMatrix);
        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Image\ImageIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new ImageIndividualDecoratorCli($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();

        $this->assertStringEqualsFile(__DIR__ . '/data/image01.txt', $render);
    }

    public function testRenderWithPixelsSet()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Image\Image');

        $imageMatrix = array_fill_keys(range(0, 4), 1);
        foreach ($imageMatrix as $id => $imagePart) {
            $imageMatrix[$id] = array_fill_keys(range(0, 4), 0);
        }
        $imageMatrix[1][1] = 1;
        $imageMatrix[2][2] = 1;
        $imageMatrix[3][3] = 1;

        $object->getImageMatrix()->willReturn($imageMatrix);
        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Image\ImageIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new ImageIndividualDecoratorCli($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();

        $this->assertStringEqualsFile(__DIR__ . '/data/image02.txt', $render);
    }

    protected function tearDown(): void
    {
        $this->prophet->checkPredictions();
    }
}
